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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2); // Price with 2 decimal points
            $table->string('image_url')->nullable();
            $table->timestamps();

            // Indexes for frequently searched fields
            $table->index('name'); // Full-text search on product name
            $table->index('price'); // Price-based filtering

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
