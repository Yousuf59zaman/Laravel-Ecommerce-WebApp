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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_details_id');
            // This table will store the details of each product in an order
            // The 'order_id' column will reference the 'id' column of the 'orders' table
            // We specify 'cascade' onDelete to ensure that if an order is deleted,
            // all the associated order_details records are also deleted
            $table->foreignId('order_id')
               ->onDelete('cascade'); // If an order is deleted, delete the associated order_details records

            // This column will reference the 'id' column of the 'products' table
            // We specify 'cascade' onDelete to ensure that if a product is deleted,
            // all the associated order_details records are also deleted
            $table->foreignId('product_id')
                ->constrained() // Constrain the 'product_id' column to the 'id' column of the 'products' table
                ->onDelete('cascade'); // If a product is deleted, delete the associated order_details records

            // This column will store the quantity of the product in the order
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
