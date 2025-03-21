<?php

use App\Services\Api\V1\PaymentGateways\PaymentGatewayInterface;


class MyFatooraPaymentGateway implements PaymentGatewayInterface
{
    public function processPayment(float $amount, array $data): array
    {
        return [
            'success' => true,
            'message' => 'Payment processed via MyFatoora',
            'gateway' => $this->getGatewayName(),
            'amount' => $amount,
            'data' => $data,
        ];
    }

    public function getGatewayName(): string
    {
        return 'my-fatoora';
    }
}