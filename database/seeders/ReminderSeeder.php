<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceAvailability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0;$i<100;$i++){

            $service = Service::factory()->create();
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri','Sat', 'Sun'];
            for($di = 0;$di<7;$di++){
                $day = $days[$di];
                if(fake()->boolean(rand(1,100))){
                    ServiceAvailability::factory()->for($service, 'service')->create([
                        'day' => $day
                    ]);
                }
            }
           

        }
    }
}
