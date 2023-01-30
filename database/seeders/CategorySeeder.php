<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'kırtasiye',
            'televizyon',
            'cep telefonu',
            'mobilya',
            'içecek',
            'gıda',
            'hırdavat'
        ];

        foreach($categories as $category){
            DB::table('categories')->insert([
                'name' => $category,
                'slug' =>str_slug($category),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
