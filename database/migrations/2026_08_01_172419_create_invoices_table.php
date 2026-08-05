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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')->unique();
            $table->foreignId('client_id')->constrained();
            $table->timestamp('issue_date')->nullable();
            $table->date('sale_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->default('unpaid');
            $table->decimal('total_net', 12, 2)->default(0);
            $table->decimal('total_vat', 12, 2)->default(0);
            $table->decimal('total_gross', 12, 2)->default(0);
            $table->string('reference')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
