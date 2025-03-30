<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Provider;
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
            'name' => $this->faker->word(),
            'description' => $this->faker->sentences(asText:true),
            'price' => $this->faker->randomFloat(1,1,1000),
            'quantity' => $this->faker->randomNumber(6),
            'category_id' => Category::inRandomOrder()->first()->id,
            'provider_id' => Provider::inRandomOrder()->first()->id ?? Provider::factory()->create()->id
        ];
    }
}
