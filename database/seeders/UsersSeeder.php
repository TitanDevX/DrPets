<?php

namespace Database\Seeders;

use App\Enums\InvoiceTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('name', '=', 'Test Provider')->exists()) {
            $user = User::factory()->create([
                'name' => 'Test Provider',
                'email' => 'testprovider@example.com',
                'password' => bcrypt("123123")
            ]);
            Address::factory()->count(1)->for($user, 'addressable')->create();
            
            $prov = Provider::factory()->for( $user, 'user')->create();
            Address::factory()->for($prov, 'addressable')->create();
        }
        if (!User::where('name', '=', 'Test User')->exists()) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt("123123")
            ]);
            Address::factory()->count(3)->for($user, 'addressable')->create();
            Reminder::factory()->count(5)->for($user)->create();
            Cart::factory()->count(5)->for($user)->create();


            for ($i = 0; $i < 5; $i++) {
                $pet = Pet::factory()->for($user)->create();
                $service = Service::factory()->create();
                Address::factory()->for($service, 'addressable')->create();
                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                for ($di = 0; $di < 7; $di++) {
                    $day = $days[$di];
                    if (fake()->boolean(rand(1, 100))) {
                        ServiceAvailability::factory()->for($service, 'service')->create([
                            'day' => $day
                        ]);
                    }
                }


                $invoice = Invoice::factory()->for($user, 'user')->for(PromoCode::factory(), 'promoCode')->make([
                    'type' => InvoiceTypeEnum::ORDER->value,
                ]);
                $prs = Product::factory()->count(5)->create();
                foreach ($prs as $key => $value) {
                    $invoice->subTotal += $value->price;
                }

                $invoice->total = $invoice->subTotal + $invoice->fee + $invoice->tax;
                $invoice->save();
                $invoice = Invoice::factory()->for($user, 'user')->for(PromoCode::factory(), 'promoCode')->make([
                    'type' => InvoiceTypeEnum::BOOKING->value,
                ]);
                $booking = Booking::factory()->for($pet)->for($invoice)->for($service)->create([
                    'service_availability_id' => ServiceAvailability::where('service_id', '=', $service->id)->inRandomOrder()->first()->id
                ]);
                $invoice->subTotal= $service->price;
                $invoice->total = $invoice->subTotal + $invoice->fee + $invoice->tax;
                $invoice->save();
            }
        }

    }
}
