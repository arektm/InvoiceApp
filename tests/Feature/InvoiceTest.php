<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->user = User::factory()->create();

    $this->actingAs($this->user);

});

it('can display invoices page', function () {

    Invoice::factory()
        ->count(5)
        ->create();

    $response = $this->get(
        route('invoices.index')
    );

    $response
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Invoices/Index')
        );

});

it('can display create invoice page', function () {

    $response = $this->get(
        route('invoices.create')
    );

    $response
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Invoices/Create')
        );

});

it('can create invoice with items', function () {

    $client = Client::factory()->create();

    $product = Product::factory()->create([

        'net_price' => 100,

        'vat_rate' => 23,

    ]);

    $response = $this->post(

        route('invoices.store'),

        [

            'client_id' => $client->id,

            'issue_date' => now()->format('Y-m-d'),

            'sale_date' => now()->format('Y-m-d'),

            'due_date' => now()
                ->addDays(14)
                ->format('Y-m-d'),

            'payment_method' => 'bank transfer',

            'items' => [

                [

                    'product_id' => $product->id,

                    'quantity' => 2,

                ],

            ],

        ]

    );

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseCount(
        'invoices',
        1
    );

    $this->assertDatabaseHas(
        'invoice_items',
        [

            'product_id' => $product->id,

            'quantity' => 2,

        ]
    );

    $invoice = Invoice::first();

    expect($invoice->total_net)
        ->toBe(200);

    expect($invoice->total_vat)
        ->toBe(46);

    expect($invoice->total_gross)
        ->toBe(246);

});

it('validates invoice required fields', function () {

    $response = $this->post(

        route('invoices.store'),

        []

    );

    $response->assertSessionHasErrors([

        'client_id',

        'issue_date',

        'items',

    ]);

});

it('can display invoice details', function () {

    $invoice = Invoice::factory()->create();

    $response = $this->get(

        route('invoices.show', $invoice)

    );

    $response
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Invoices/Show')
        );

});

it('can update invoice', function () {

    $client = Client::factory()->create();

    $product = Product::factory()->create([
        'net_price' => 100,
        'vat_rate' => 23,
    ]);

    $invoice = Invoice::factory()->create([
        'client_id' => $client->id,
        'status' => 'unpaid',
    ]);

    $invoice->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->product_name,
        'quantity' => 1,
        'unit_net_price' => $product->net_price,
        'vat_rate' => $product->vat_rate,
        'net_value' => 100,
        'vat_value' => 23,
        'gross_value' => 123,
    ]);

    $response = $this->put(
        route('invoices.update', $invoice),
        [

            'client_id' => $client->id,

            'issue_date' => now()->format('Y-m-d'),

            'sale_date' => now()->format('Y-m-d'),

            'due_date' => now()
                ->addDays(14)
                ->format('Y-m-d'),

            'payment_method' => 'cash',

            'status' => 'paid',

            'items' => [

                [

                    'product_id' => $product->id,

                    'quantity' => 3,

                ],

            ],

        ]
    );

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('invoices.index'));

    $this->assertDatabaseHas('invoices', [

        'id' => $invoice->id,

        'status' => 'paid',

        'payment_method' => 'cash',

        'total_net' => 300.00,

        'total_vat' => 69.00,

        'total_gross' => 369.00,

    ]);

    $this->assertDatabaseHas('invoice_items', [

        'invoice_id' => $invoice->id,

        'product_id' => $product->id,

        'quantity' => 3,

        'net_value' => 300.00,

        'vat_value' => 69.00,

        'gross_value' => 369.00,

    ]);

});

it('can soft delete invoice', function () {

    $invoice = Invoice::factory()->create();

    $response = $this->delete(

        route('invoices.destroy', $invoice)

    );

    $response->assertRedirect();

    $this->assertSoftDeleted(
        'invoices',
        [

            'id' => $invoice->id,

        ]
    );

});
