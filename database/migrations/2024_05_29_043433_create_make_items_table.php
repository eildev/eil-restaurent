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
        Schema::create('make_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('make_category_id')->unsigned();
            $table->foreign('make_category_id')->references('id')->on('item_categories')->onDelete('cascade');
            $table->string('item_name');
            $table->string('barcode')->default(rand(100000,123456789));
            $table->decimal('cost_price',12,2);
            $table->decimal('sale_price',12,2)->default(0);
            $table->string('picture')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('active');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('make_items');
    }
};
