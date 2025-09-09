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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('cart_items');
            $table->decimal('subtotal', 15)->default(0);
            $table->decimal('charges', 15)->default(0);
            $table->decimal('discount', 15)->default(0);
            $table->decimal('total', 15)->default(0);
            $table->decimal('amount', 15)->default(0);
            $table->string('coupon')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('channel')->nullable();
            $table->string('transaction_reference')->unique()->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
