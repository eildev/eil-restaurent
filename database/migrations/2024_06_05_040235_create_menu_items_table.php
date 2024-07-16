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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->unsignedBigInteger('menu_id')->unsigned();
            $table->foreign('menu_id')->references('id')->on('set_menus')->onDelete('cascade');
            $table->unsignedBigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('make_items')->onDelete('cascade');
            $table->string('quantity');
            $table->decimal('apro_cost',12,2);
            $table->string('status')->default('active');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
