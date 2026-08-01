<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->string('product_name');
            $table->integer('quantity')->default(0);
            $table->decimal('unit_net_price', 10, 2);
            $table->decimal('vat_rate', 5, 2)->default(23);
            $table->decimal('net_value')->default(0);
            $table->decimal('vat_value')->default(0);
            $table->decimal('discount', 3, 2)->default(0);
            $table->decimal('gross_value', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
