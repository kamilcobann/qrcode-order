<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 9; $i++) { 
            $name = $faker->name();
            DB::table('products')->insert([
                'category_id' => rand(1,7),
                'name' => $name,
                'slug' => str_slug($name),
                'image' => $faker->imageUrl($width = 800, $height = 400,'cats',true),
                'description' => $faker->realText($maxNbChars = 30),
                'price' => (double)(rand(1,30)),
                'amount' => rand(1,300),
            ]);
        }
    }
}
