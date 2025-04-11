<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {  
       
        $jsonPath = storage_path('app\data\example_pet_names.json');
        $petNames = json_decode(file_get_contents($jsonPath), true)['pet_names'];
        return [
            'name' => $this->faker->randomElements($petNames)[0],
            'description' => $this->faker->paragraph(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'birth' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'breed_id' => Breed::inRandomOrder()->first()->id,
        ];
    }
}
