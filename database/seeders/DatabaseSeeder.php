<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if(!User::where('name','=','Test user')->exists()){
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',

        ]);
        Address::factory()->count(3)->for($user, 'addressable')->create(); 

    }
       
        for($i = 0;$i<100;$i++){
            Address::factory()->count(4)->for(User::factory(),'addressable')->create();
        }
        
    }
}
