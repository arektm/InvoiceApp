<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $net = fake()->randomFloat(2, 100, 10000);
        $vat = round($net * 0.23, 2);
        $gross = $net + $vat;
        $issueDate = fake()->dateTimeBetween('-3 months', 'now');
        $dueDate = (clone $issueDate)->modify('+7 days');

        return [
            'invoice_number' => 'FV'.'/'.now()->year.'/'.now()->month.'/'.fake()->unique()->numberBetween(100, 999),
            'client_id' => Client::factory(),
            'issue_date' => $issueDate,
            'sale_date' => $issueDate,
            'due_date' => $dueDate,
            'payment_method' => fake()->randomElement([
                'bank transfer',
                'cash',
                'card',
            ]),

            'status' => fake()->randomElement([
                'paid',
                'unpaid',
                'cancelled',
            ]),
            'total_net' => $net,
            'total_vat' => $vat,
            'total_gross' => $gross,
        ];
    }
}
