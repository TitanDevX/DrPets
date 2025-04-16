<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceContent;
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
        if(!User::where('name','=','Test user')->exists()){
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt("123123")
        ]);
        Address::factory()->count(3)->for($user, 'addressable')->create(); 
        Reminder::factory()->count(5)->for($user)->create();
        Cart::factory()->count(5)->for($user)->create();
      
        
        for($i = 0;$i<5;$i++){
            $pet = Pet::factory()->for($user)->create();
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
               
    
            $invoice = Invoice::factory()->for($user, 'user')->for(PromoCode::factory(), 'promoCode')->make();
            $prs = Product::factory()->count(5)->create();
            foreach ($prs as $key => $value) {
                $invoice->subTotal += $value->price;
            }
          
            $invoice->total = $invoice->subTotal+$invoice->fee+$invoice->tax ;
            $invoice->save();
            foreach ($prs as $key => $value) {
                $c = InvoiceContent::factory()->for($invoice,'invoice')
                ->for($value,'invoicable')
                ->create();
            }
            Booking::factory()->for($pet)->for($invoice)->for($service)->create([
                'service_availability_id' => ServiceAvailability::where('service_id', '=', $service->id)->inRandomOrder()->first()->id
            ]);
        }
        }
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
        User::factory()->count(10)->create();
        Provider::factory()->count(10)->create();
        for($i = 0;$i<100;$i++){
            Address::factory()->count(4)->for(User::factory(),'addressable')->create();
        }
        Reminder::factory()->count(50)->create();

        Product::factory()->count(100)->create();
      
        Pet::factory()->count(50)->create();
        Cart::factory()->count(50)->create();
      


        $roles = [
            'admin' => [
                'pet.rete'
            ]
        ];
        

    }
}
