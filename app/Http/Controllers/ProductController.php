<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()

            ->when($request->search, function ($query, $search) {

                $query->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            })

            ->orderBy('product_name')

            ->paginate(10)

            ->withQueryString()

            ->through(fn ($product) => [

                'id' => $product->id,

                'product_code' => $product->product_code,

                'product_name' => $product->product_name,

                'net_price' => $product->net_price,

                'vat_rate' => $product->vat_rate,

                'stock_quantity' => $product->stock_quantity,
            ]);

        return Inertia::render('Products/Index', [

            'filters' => [
                'search' => $request->search,
            ],

            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => ['required', 'unique:products,product_code'],
            'product_name' => ['required', 'max:255'],
            'description' => ['nullable'],
            'net_price' => ['required', 'numeric', 'min:0'],
            'vat_rate' => ['required', 'numeric'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [

            'product' => [

                'id' => $product->id,

                'product_code' => $product->product_code,

                'product_name' => $product->product_name,

                'description' => $product->description,

                'net_price' => $product->net_price,

                'vat_rate' => $product->vat_rate,

                'stock_quantity' => $product->stock_quantity,

                'created_at' => $product->created_at->format('Y-m-d H:i'),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('edit', Product::class);

        return Inertia::render('Products/Edit', [

            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('create', $product);
        $validated = $request->validate([

            'product_code' => [
                'required',
                'unique:products,product_code,'.$product->id,
            ],

            'product_name' => [
                'required',
                'max:255',
            ],

            'description' => [
                'nullable',
            ],

            'net_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'vat_rate' => [
                'required',
                'numeric',
            ],

            'stock_quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        // dd($product);
        if ($product->invoiceItems()->exists()) {

            return back()->withErrors([
                'delete' => 'The product appears on invoices and cannot be removed.',
            ]);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Poduct removed');
    }
}
