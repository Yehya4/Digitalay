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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 200);
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->text('note')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 20)->default('pending');
            $table->string('payment_method', 20)->default('bank_transfer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
