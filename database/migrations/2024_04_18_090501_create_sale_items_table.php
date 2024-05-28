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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->decimal('rate',10,2);
            $table->integer('main_unit_qty')->nullable();
            $table->integer('sub_unit_qty')->nullable();
            $table->integer('qty');
            $table->decimal('sub_total',12,2);
            $table->decimal('total_purchase_cost', 12, 2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
