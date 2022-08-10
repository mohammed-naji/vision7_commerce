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
    public function definition()
    {
        return [
            'name' => fake()->words(4, true),
            'content' => fake()->paragraphs(4, true),
            'image' => fake()->imageUrl(),
            'price' => fake()->numberBetween(10, 100),
            'sale_price' => fake()->numberBetween(0, 50),
            'quantity' => fake()->numberBetween(100, 1000),
            'user_id' => fake()->numberBetween(1, 10),
            'category_id' => fake()->numberBetween(1, 50),
        ];
    }
}
