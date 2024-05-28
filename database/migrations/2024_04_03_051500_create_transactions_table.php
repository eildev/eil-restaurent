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
            $table->date('date')->nullable();
            $table->enum('payment_type', ['receive', 'pay'])->comment('Recieve or Pay');
            $table->string('particulars')->nullable()->comment('Purchase #12 or Paid to Supplyer/Sale #10 Received from Customer');
            $table->integer('customer_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->decimal('debit', 12, 2)->nullable();
            $table->decimal('credit', 12, 2)->nullable();
            $table->decimal('balance', 14, 2);
            $table->integer('payment_method');
            $table->string('note')->nullable();
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
