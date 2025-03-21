<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'total_amount' => 1949.97,
                'status' => 'confirmed',
                'shipping_address' => json_encode([
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'phone' => '123-456-7890',
                    'city' => 'New York',
                    'address' => '123 Main St',
                ]),
                'payment_method' => 'kashier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'total_amount' => 349.99,
                'status' => 'pending',
                'shipping_address' => json_encode([
                    'name' => 'Jane Smith',
                    'email' => 'jane.smith@example.com',
                    'phone' => '987-654-3210',
                    'city' => 'Los Angeles',
                    'address' => '456 Elm St',
                ]),
                'payment_method' => 'myfatoora',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
