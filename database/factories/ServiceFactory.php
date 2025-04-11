<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Pet;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => substr($this->faker->sentence(3),0,30),
            'price' => $this->faker->randomFloat(1,1,1000),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'provider_id' => Provider::inRandomOrder()->first()->id ?? Provider::factory()->create()->id,
            'pet_id' => Pet::inRandomOrder()->first()->id ?? Pet::factory()->create()->id,
        ]
        ;
    }
}
