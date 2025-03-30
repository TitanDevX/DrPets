<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $min = 0;
        $max = 80;
        $randomFloat = round($min + mt_rand() / mt_getrandmax() * ($max - $min), 2);
        return [
            'value' => $randomFloat,
            'code' => $this->faker->regexify('^[A-Za-z0-9]{10}$')
        ];
    }
}
