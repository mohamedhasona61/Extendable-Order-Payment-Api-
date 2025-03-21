<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_details')->truncate();

        DB::table('order_details')->insert([
            [
                'order_id' => 1,
                'product_id' => 1, 
                'quantity' => 2,
                'price' => 799.99,
                'subtotal' => 1599.98, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1, 
                'product_id' => 3, 
                'quantity' => 1,
                'price' => 349.99,
                'subtotal' => 349.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2, 
                'product_id' => 2, 
                'quantity' => 3,
                'price' => 699.99,
                'subtotal' => 2099.97,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
