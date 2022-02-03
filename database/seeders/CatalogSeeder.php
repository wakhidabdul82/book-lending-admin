<?php

namespace Database\Seeders;

use App\Models\Catalog;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CatalogSeeder extends Seeder
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
        
            $cat = new Catalog;

            $cat->name = $faker->name;

            $cat->save();
    	}
    }
}
