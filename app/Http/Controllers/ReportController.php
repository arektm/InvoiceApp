<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $todaySales = Invoice::whereDate(
        //     'issue_date',
        //     today()
        // )->sum('total_gross');

        $todaySales = Invoice::whereDate('issue_date', now()->today())
            ->sum('total_gross');

        $monthSales = Invoice::whereMonth(
            'issue_date',
            now()->month
        )
            ->whereYear(
                'issue_date',
                now()->year
            )
            ->sum('total_gross');

        $yearSales = Invoice::whereYear(
            'issue_date',
            now()->year
        )->sum('total_gross');

        $invoiceCount = Invoice::count();

        $unpaidInvoices = Invoice::where(
            'status',
            'unpaid'
        )->count();

        $overdueInvoices = Invoice::where(
            'status',
            'unpaid'
        )
            ->whereDate(
                'due_date',
                '<',
                now()
            )
            ->count();

        $topClients = Client::query()

            ->withSum(
                'invoices',
                'total_gross'
            )

            ->orderByDesc(
                'invoices_sum_total_gross'
            )

            ->limit(10)

            ->get();

        $topProducts = InvoiceItem::query()

            ->selectRaw('
                product_id,
                SUM(quantity) as total_quantity
            ')

            ->with('product')

            ->groupBy('product_id')

            ->orderByDesc('total_quantity')

            ->limit(10)

            ->get();

        return Inertia::render(
            'Reports/Index',
            [

                'todaySales' => $todaySales,

                'monthSales' => $monthSales,

                'yearSales' => $yearSales,

                'invoiceCount' => $invoiceCount,

                'unpaidInvoices' => $unpaidInvoices,

                'overdueInvoices' => $overdueInvoices,

                'topClients' => $topClients,

                'topProducts' => $topProducts,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $Report)
    {
        //
    }

    public function unpaidInvoices()
    {
        $invoices = Invoice::query()

            ->with('client')

            ->where('status', 'unpaid')
            

            ->orderBy('due_date')

            ->paginate(20)

            ->through(fn ($invoice) => [

                'id' => $invoice->id,

                'invoice_number' => $invoice->invoice_number,

                'issue_date' => $invoice->issue_date->format('Y-m-d'),

                'due_date' => $invoice->due_date->format('Y-m-d'),

                'total_gross' => $invoice->total_gross,

                'client_name' => $invoice->client?->name,

                'client_email' => $invoice->client?->email,

                // 'days_overdue' => now()
                //     ->greaterThan($invoice->due_date)
                //         ? now()->diffInDays($invoice->due_date)
                //         : 0,
                'days_overdue' => $invoice->due_date->isPast()
                    ? (int) $invoice->due_date->diffInDays(now()->today())
                    : (int) $invoice->due_date->diffInDays(now()->today()),
            ]);

        return Inertia::render(
            'Reports/UnpaidInvoices',
            [
                'invoices' => $invoices,
            ]
        );
    }


    public function overdueInvoices()
    {
        $invoices = Invoice::query()

            ->with('client')

            ->where('status', 'unpaid')

            ->whereDate('due_date', '<', today())

            ->orderBy('due_date')

            ->paginate(20)

            ->through(fn ($invoice) => [

                'id' => $invoice->id,

                'invoice_number' => $invoice->invoice_number,

                'issue_date' => $invoice->issue_date->format('Y-m-d'),

                'due_date' => $invoice->due_date->format('Y-m-d'),

                'total_gross' => $invoice->total_gross,

                'client_name' => $invoice->client?->name,

                'client_email' => $invoice->client?->email,

                'days_overdue' => (int) $invoice->due_date->diffInDays(today()),
            ]);

        return Inertia::render(
            'Reports/OverdueInvoices',
            [
                'invoices' => $invoices,
            ]
        );
    }
}
