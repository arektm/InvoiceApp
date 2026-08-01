<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    // -------------------------------------------------------------------------
    // Public actions
    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $invoices = Invoice::query()
            ->with('client')
            ->when($request->search, function ($query, $search) {
                $query->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('client', fn ($q) => $q
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                    );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($invoice) => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'issue_date' => $invoice->issue_date->format('Y/m/d'),
                'due_date' => $invoice->due_date->format('Y/m/d'),
                'status' => $invoice->status,
                'total_gross' => $invoice->total_gross,
                'name' => $invoice->client?->name,
                'email' => $invoice->client?->email,
            ]);

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('Invoices/Create', [
            'clients' => Client::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'products' => Product::query()
                ->select('id', 'product_name', 'net_price', 'vat_rate')
                ->orderBy('product_name')
                ->get(),
        ]);
    }

    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            // Load all required products in a single query — avoids N+1 inside the loop.
            $productIds = collect($validated['items'])->pluck('product_id')->unique();
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $invoice = Invoice::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'client_id' => $validated['client_id'],
                'issue_date' => $validated['issue_date'],
                'sale_date' => $validated['sale_date'],
                'due_date' => $validated['due_date'],
                'payment_method' => $validated['payment_method'],
                'status' => 'unpaid',
                'total_net' => 0,
                'total_vat' => 0,
                'total_gross' => 0,
            ]);

            $totalNet = 0;
            $totalVat = 0;
            $totalGross = 0;

            $lineItems = [];

            foreach ($validated['items'] as $row) {
                $product = $products[$row['product_id']];

                $net = round($product->net_price * $row['quantity'], 2);
                $vat = round($net * ($product->vat_rate / 100), 2);
                $gross = $net + $vat;

                $lineItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'quantity' => $row['quantity'],
                    'unit_net_price' => $product->net_price,
                    'vat_rate' => $product->vat_rate,
                    'net_value' => $net,
                    'vat_value' => $vat,
                    'gross_value' => $gross,
                ];

                $totalNet += $net;
                $totalVat += $vat;
                $totalGross += $gross;
            }

            // Bulk-insert all line items in one query instead of one per item.
            $invoice->items()->createMany($lineItems);

            $invoice->update([
                'total_net' => round($totalNet, 2),
                'total_vat' => round($totalVat, 2),
                'total_gross' => round($totalGross, 2),
            ]);
        });

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice created');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'items.product']);

        return Inertia::render('Invoices/Show', [
            'invoice' => $this->formatInvoice($invoice),
        ]);
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load([
            'items.product',
            'client',
        ]);

        return Inertia::render('Invoices/Edit', [

            'invoice' => [

                'id' => $invoice->id,

                'client_id' => $invoice->client_id,
                'invoice_number' => $invoice->invoice_number,
                'issue_date' => $invoice->issue_date->format('Y-m-d'),
                'sale_date' => $invoice->sale_date->format('Y-m-d'),
                'due_date' => $invoice->due_date->format('Y-m-d'),
                'status' => $invoice->status,
                'payment_method' => $invoice->payment_method,

                'items' => $invoice->items->map(function ($item) {

                    return [
                        'id' => $item->id,

                        'product_id' => $item->product_id,

                        'product_name' => $item->product?->product_name,

                        'quantity' => $item->quantity,
                    ];
                }),
            ],

            'clients' => Client::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'products' => Product::query()
                ->select(
                    'id',
                    'product_name',
                    'net_price',
                    'vat_rate'
                )
                ->orderBy('product_name')
                ->get(),
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {

        $validated = $request->validate([

            'client_id' => ['required'],

            'issue_date' => ['required'],
            'sale_date' => ['required'],
            'due_date' => ['required'],
            'status' => [
                'required', 'in:paid,unpaid,cancelled',
            ],
            'payment_method' => ['required'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $invoice
        ) {

            $productIds = collect(
                $validated['items']
            )->pluck('product_id')
                ->unique();

            $products = Product::whereIn(
                'id',
                $productIds
            )->get()->keyBy('id');

            $invoice->update([

                'client_id' => $validated['client_id'],

                'issue_date' => $validated['issue_date'],

                'sale_date' => $validated['sale_date'],

                'due_date' => $validated['due_date'],

                'payment_method' => $validated['payment_method'],
                'status' => $validated['status'],
            ]);

            $invoice->items()->delete();

            $totalNet = 0;
            $totalVat = 0;
            $totalGross = 0;

            $items = [];

            foreach (
                $validated['items'] as $row
            ) {

                $product =
                    $products[$row['product_id']];

                $net = round(
                    $product->net_price *
                    $row['quantity'],
                    2
                );

                $vat = round(
                    $net *
                    ($product->vat_rate / 100),
                    2
                );

                $gross = $net + $vat;

                $items[] = [

                    'product_id' => $product->id,

                    'product_name' => $product->product_name,

                    'quantity' => $row['quantity'],

                    'unit_net_price' => $product->net_price,

                    'vat_rate' => $product->vat_rate,

                    'net_value' => $net,

                    'vat_value' => $vat,

                    'gross_value' => $gross,
                ];

                $totalNet += $net;
                $totalVat += $vat;
                $totalGross += $gross;
            }

            $invoice->items()->createMany(
                $items
            );

            $invoice->update([

                'total_net' => round($totalNet, 2),

                'total_vat' => round($totalVat, 2),

                'total_gross' => round($totalGross, 2),
            ]);
        });

        return redirect()
            ->route('invoices.index')
            ->with(
                'success',
                'Invoice updated'
            );
    }

    public function destroy(Invoice $invoice)
    {
        //
    }

    

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Generate a unique invoice number inside a lock so concurrent requests
     * cannot produce the same number.
     */
    private function generateInvoiceNumber(): string
    {
        // Lock the invoices table row with the highest id to prevent race conditions.
        $lastId = Invoice::lockForUpdate()->max('id') + 1;

        return 'FV/'.now()->format('Y/m/').str_pad($lastId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Transform an eager-loaded Invoice into the array shape expected by Inertia views.
     * Reused by show(), pdf(), and print() so the shape stays consistent.
     */
    private function formatInvoice(Invoice $invoice): array
    {
        return [
            'id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'issue_date' => $invoice->issue_date->format('Y/m/d'),
            'sale_date' => $invoice->sale_date->format('Y/m/d'),
            'due_date' => $invoice->due_date->format('Y/m/d'),
            'status' => $invoice->status,
            'payment_method' => $invoice->payment_method,
            'total_net' => $invoice->total_net,
            'total_vat' => $invoice->total_vat,
            'total_gross' => $invoice->total_gross,
            'client' => $invoice->client,
            'items' => $invoice->items->map(fn ($item) => [
                'id' => $item->id,
                'product_name' => $item->product->product_name,
                'quantity' => $item->quantity,
                'unit_net_price' => $item->unit_net_price,
                'vat_rate' => $item->vat_rate,
                'net_value' => $item->net_value,
                'vat_value' => $item->vat_value,
                'gross_value' => $item->gross_value,
            ]),
        ];
    }

  
}
