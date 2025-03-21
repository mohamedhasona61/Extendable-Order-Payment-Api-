<?php

use App\Models\Payment;
use App\Services\Api\V1\PaymentGateways\PaymentGatewayInterface;


class KashierPaymentGateway implements PaymentGatewayInterface
{
    public function processPayment(float $amount, array $data): array
    {
        $payment = Payment::create([
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id'],
            'payment_gateway_id' => $data['payment_gateway_id'],
            'amount' => $amount,
        ]);
        // Perform Kashier payment processing here
        // Update payment status and other relevant details
        // Return success response with payment details
        return [
            'success' => true,
            'message' => 'Payment processed via Kashier Payment',
            'gateway' => $this->getGatewayName(),
            'amount' => $amount,
            'data' => $data,
        ];
    }
    public function getGatewayName(): string
    {
        return 'kashier';
    }
}
