<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    protected static ?string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Client::factory(20)->create();
        Product::factory(50)->create();
        Invoice::factory(20)
            ->create()
            ->each(function ($invoice) {

                InvoiceItem::factory(
                    rand(1, 5)
                )->create([
                    'invoice_id' => $invoice->id,
                ]);
            });
        // For tests only not for production
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@local.com',
            'password' => static::$password ??= Hash::make('aaaaaaaa'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Accuntant',
            'email' => 'ac@local.com',
            'password' => static::$password ??= Hash::make('aaaaaaaa'),
            'role' => 'accountant',
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@local.com',
            'password' => static::$password ??= Hash::make('aaaaaaaa'),
            'role' => 'user',
        ]);
    }
}
