<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_code' => 'PR-000'.fake()->unique()->numberBetween(100, 999),
            'product_name' => fake()->word(),
            'description' => fake()->sentence(),
            'net_price' => number_format((mt_rand(1000, 90000)) / 100, 2),
            'vat_rate' => '23',
            'stock_quantity' => rand(20, 300),
        ];
    }
}
