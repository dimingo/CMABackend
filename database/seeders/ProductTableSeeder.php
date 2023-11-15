<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Product::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 3; $i++) {
            Product::create([
                'name' => $faker->sentence(1),
                'description' => $faker->sentence(20),
                'price' => $faker->randomFloat(2, 1, 8000),
            ]);
        }
    }
}
