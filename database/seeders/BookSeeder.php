<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
    	for($i = 0; $i < 15; $i++){
        
            $book = new Book;

            $book->isbn = $faker->randomNumber(9);
            $book->title = $faker->realText($maxNbChars = 25);
            $book->year = rand(2010,2022);
            $book->publisher_id = rand(1,10);
            $book->author_id = rand(1,10);
            $book->catalog_id = rand(1,10);
            $book->qty = rand(5,30);
            $book->price = rand(10000,150000);

            $book->save();
    	}
    }
}
