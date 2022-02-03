<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
    	for($i = 0; $i < 3; $i++){
        
            $trans = new Transaction;

            $trans->member_id = rand(1, 25);
            $trans->date_start = $faker->dateTime();
            $trans->date_end = $faker->dateTime();
            $trans->status = rand(0, 1);

            $trans->save();
    	}
    }
}
