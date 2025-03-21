<?php

use App\Services\Api\V1\PaymentGateways\PaymentGatewayInterface;


class PaymentContext
{
    private PaymentGatewayInterface $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
    public function setPaymentGateway(PaymentGatewayInterface $paymentGateway): void
    {
        $this->paymentGateway = $paymentGateway;
    }
    public function processPayment(float $amount, array $data): array
    {
        return $this->paymentGateway->processPayment($amount, $data);
    }
}
