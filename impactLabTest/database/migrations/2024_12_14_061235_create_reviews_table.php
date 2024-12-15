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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Foreign key to customers
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');   // Foreign key to products
            $table->tinyInteger('rating')->unsigned()->default(1); // Rating (1-5 stars)
            $table->text('review')->nullable(); // Review text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
