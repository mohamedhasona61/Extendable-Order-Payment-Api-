<?php

namespace App\Services\Api\V1\PaymentGateways;

interface PaymentGatewayInterface
{
    public function processPayment(float $amount, array $data): array;
    public function getGatewayName(): string;
}
