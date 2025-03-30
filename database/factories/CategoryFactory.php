<?php

namespace Database\Factories;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{

    public function service(){
        return $this->state(function (array $attributes) {
            return [
                'type' => CategoryType::SERVICE->value,
            ];
        });
    }
    public function product(){
        return $this->state(function (array $attributes) {
            return [
                'type' => CategoryType::PRODUCT->value,
            ];
        });
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      
               
            
                return [
                    'enabled' => $this->faker->boolean
                ];
        
    }
}
