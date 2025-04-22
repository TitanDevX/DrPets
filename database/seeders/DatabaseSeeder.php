<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceContent;
use App\Models\InvoiceItem;
use App\Models\Pet;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Provider;
use App\Models\Reminder;
use App\Models\Service;
use App\Models\ServiceAvailability;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\ChanceGenerator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        PromoCode::factory()->count(50)->create();
        resolve(CategorySeeder::class)->run();
        resolve(BreedSeeder::class)->run();
        resolve(PermissionSeeder::class)->run();
        resolve(UsersSeeder::class)->run();
     
        for ($i = 0; $i < 100; $i++) {

            $service = Service::factory()->create();
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            for ($di = 0; $di < 7; $di++) {
                $day = $days[$di];
                if (fake()->boolean(rand(1, 100))) {
                    ServiceAvailability::factory()->for($service, 'service')->create([
                        'day' => $day
                    ]);
                }
            }


        }
       
        for($i = 0;$i<10;$i++){
           $user = User::factory()->create();
           Provider::factory()->create([
            'user_id' => $user->id
           ]);
        }
       
       
        for ($i = 0; $i < 100; $i++) {
            Address::factory()->count(4)->for(User::factory(), 'addressable')->create();
        }
        Reminder::factory()->count(50)->create();

        Product::factory()->count(100)->create();

        Pet::factory()->count(50)->create();
        Cart::factory()->count(50)->create();

       

    }
}
