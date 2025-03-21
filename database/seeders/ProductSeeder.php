<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Apple iPhone 13',
                'description' => 'The latest iPhone with A15 Bionic chip, Super Retina XDR display, and advanced dual-camera system.',
                'status' => 'active',
                'price' => 799.99,
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'description' => 'Flagship smartphone with 5G, Dynamic AMOLED 2X display, and triple camera system.',
                'status' => 'active',
                'price' => 699.99,
            ],
            [
                'name' => 'Sony WH-1000XM4',
                'description' => 'Industry-leading noise canceling over-ear headphones with exceptional sound quality.',
                'status' => 'active',
                'price' => 349.99,
            ],
            [
                'name' => 'MacBook Air M1',
                'description' => 'Lightweight laptop with Apple M1 chip, Retina display, and all-day battery life.',
                'status' => 'active',
                'price' => 999.99,
            ],
            [
                'name' => 'Amazon Echo Dot (4th Gen)',
                'description' => 'Smart speaker with Alexa, sleek design, and improved sound quality.',
                'status' => 'active',
                'price' => 49.99,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
