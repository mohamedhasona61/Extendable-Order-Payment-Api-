<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_gateways')->insert([
            [
                'name' => 'myfatoora',
                'status' => 'active',
                'config' => json_encode([
                    'api_key' => 'sk_test_12345',
                    'webhook_secret' => 'whsec_67890',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'kashier',
                'status' => 'disactive',
                'config' => json_encode([
                    'merchant_id' => 'merchant_123',
                    'api_key' => 'api_456',
                    'mode' => 'live',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
