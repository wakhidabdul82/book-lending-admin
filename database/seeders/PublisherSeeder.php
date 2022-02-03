<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
    	for($i = 0; $i < 10; $i++){
        
            $pub = new Publisher;

            $pub->name = $faker->name;
            $pub->email = $faker->email;
            $pub->phone_number = '081' .$faker->randomNumber(9);
            $pub->address = $faker->address;

            $pub->save();
    	}
    }
}
