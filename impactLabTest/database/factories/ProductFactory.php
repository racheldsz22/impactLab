<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // Generate a random product name
            'description' => $this->faker->sentence(10), // Short description
            'price' => $this->faker->randomFloat(2, 1, 500), // Random price between 1 and 500
            'quantity' => $this->faker->numberBetween(1, 500), // Random stock quantity
            'image_url' => $this->faker->imageUrl(640, 480, 'products'), // Random product image URL
        ];
    }
}
