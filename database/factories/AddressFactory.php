<?php

namespace Database\Factories;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected function withFaker(): Faker
    {
        return \Faker\Factory::create('ar_SA'); 
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $country = $this->faker->randomElement(['SY', 'US', 'SA', 'EG']);

        $cities = [
            'SY' => ['Damascus', 'Aleppo', 'Homs', 'Latakia', 'Hama'],
            'US' => ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Miami'],
            'SA' => ['Riyadh', 'Jeddah', 'Dammam', 'Medina', 'Mecca'],
            'EG' => ['Cairo', 'Alexandria', 'Giza', 'Shubra El Kheima', 'Port Said'],
        ];

        $streets = [
            'SY' => ['Al-Midan St.', 'Baramkeh St.', 'Mazzeh St.', 'Bab Touma St.', 'Shaalan St.'],
            'US' => ['Broadway St.', 'Sunset Blvd.', '5th Ave.', 'Main St.', 'Ocean Dr.'],
            'SA' => ['King Fahd Rd.', 'Tahlia St.', 'Prince Sultan St.', 'Corniche Rd.', 'Al-Madina Rd.'],
            'EG' => ['Tahrir St.', 'Ramses St.', 'October 6th St.', 'Zamalek St.', 'Heliopolis St.'],
        ];
        $addressDetails = [
            'SY' => ['Near Omayad Square', 'Next to Al-Fayhaa Stadium', 'Beside Cham City Center'],
            'US' => ['Apartment 3B, Floor 5', 'Behind the Central Park', 'Next to the subway station'],
            'SA' => ['Near Kingdom Tower', 'Beside Al-Nakheel Mall', 'Next to King Abdulaziz Hospital'],
            'EG' => ['Behind the Cairo Tower', 'Near Tahrir Square', 'Opposite to Nile Corniche'],
        ];
        $details = $this->faker->randomElement($addressDetails[$country]);
        return [
            'country' =>  $country,
            'city' => $this->faker->randomElement($cities[$country]),
            'street' => $this->faker->randomElement($streets[$country]),
            'details' => $details,
            'long' => $this->faker->longitude(),
            'lat' => $this->faker->latitude()

        ];
    }
}
