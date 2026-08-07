<?php

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);
});

it('can display products page', function () {

    Product::factory()->count(5)->create();

    $response = $this->get(route('products.index'));

    $response
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Products/Index')
        );
});

it('can create product', function () {

    $response = $this->post(route('products.store'), [

        'product_code' => 'PR-000034344',

        'product_name' => 'Laravel Book',

        'description' => 'Programming book',

        'net_price' => 99.99,

        'vat_rate' => 23,

        'stock_quantity' => 100,
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('products', [

        'product_code' => 'PR-000034344',

        'product_name' => 'Laravel Book',

        'net_price' => 99.99,

        'vat_rate' => 23,

        'stock_quantity' => 100,
    ]);
});

it('validates required fields', function () {

    $response = $this->post(route('products.store'), []);

    $response->assertSessionHasErrors([
        'product_code',
        'product_name',
        'net_price',
        'vat_rate',
        'stock_quantity',
    ]);
});

it('can update product', function () {

    $product = Product::factory()->create();

    $response = $this->put(

        route('products.update', $product),

        [
            'product_code' => $product->product_code,

            'product_name' => 'Updated Product',

            'description' => 'Updated',

            'net_price' => 150,

            'vat_rate' => 8,

            'stock_quantity' => 10,
        ]

    );

    $response->assertRedirect();

    $this->assertDatabaseHas('products', [

        'id' => $product->id,

        'product_name' => 'Updated Product',

        'net_price' => 150,

        'vat_rate' => 8,

        'stock_quantity' => 10,
    ]);
});

it('soft deletes product', function () {

    $product = Product::factory()->create();

    $response = $this->delete(

        route('products.destroy', $product)

    );

    $response->assertRedirect();

    $this->assertSoftDeleted($product);
});

it('can display product details', function () {

    $product = Product::factory()->create();

    $response = $this->get(

        route('products.show', $product)

    );

    $response
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Products/Show')
        );
});
