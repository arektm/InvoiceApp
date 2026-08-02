<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $price = fake()->randomFloat(2, 10, 1000);
        $net = $quantity * $price;
        $vat = round($net * 0.23, 2);
        $gross = $net + $vat;

        $product = Product::factory()->create();

        return [
            'invoice_id' => Invoice::factory(),
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'quantity' => $quantity,
            'unit_net_price' => $price,
            'vat_rate' => 23,
            'net_value' => $net,
            'vat_value' => $vat,
            'discount' => fake()->numberBetween(0, 70),
            'gross_value' => $gross,
        ];
    }
}
