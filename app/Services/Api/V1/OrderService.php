<?php

namespace App\Services\Api\V1;

use Exception;
use PaymentContext;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use KashierPaymentGateway;
use App\Models\OrderDetails;
use MyFatooraPaymentGateway;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\Api\V1\PaymentGateways\PaymentGatewayInterface;

class OrderService
{
    public function createOrder($data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $orderData['shipping_address'] = json_encode($data['shipping_address']);
                $orderData['user_id'] = JWTAuth::parseToken()->authenticate()->id;
                $orderData['total_amount'] = $this->calculateTotalAmount($data['products']);
                $orderData['payment_method'] = $data['payment_method'];
                $order = Order::create($orderData);
                foreach ($data['products'] as $product) {
                    $price = Product::find($product['product_id'])->price;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity'],
                        'price' => $price,
                        'subtotal' => $product['quantity'] * $price,
                    ]);
                }
                $payment = Payment::create([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'payment_gateway_id' => $data['payment_method'],
                    'amount' => $order->total_amount,
                ]);
                $paymentContext = new PaymentContext($this->getPaymentGateway($data['payment_method']));
                $paymentResult = $paymentContext->processPayment($order->total_amount, $payment);
                if (!$paymentResult['success']) {
                    throw new Exception('Payment failed: ' . $paymentResult['message']);
                }
                return [
                    'success' => true,
                    'message' => 'Order created successfully.',
                    'data' => $order,
                ];
            });
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }
    }
    public function cancelOrder($data)
    {
        $order = Order::find($data->order_id);
        if ($order->payments()->exists()) {
            return [
                'success' => false,
                'message' => 'Order has payments, so it cannot be cancelled.',
            ];
        }    
        $order->status = 'cancelled';
        $order->save();
        return [
            'success' => true,
           'message' => 'Order canceled successfully.',
        ];
    }
    private function calculateTotalAmount(array $products): float
    {
        $totalAmount = 0;
        foreach ($products as $product) {
            $productPrice = Product::find($product['product_id'])->price;
            $subtotal = $product['quantity'] * $productPrice;
            $totalAmount += $subtotal;
        }
        return $totalAmount;
    }
    private function getPaymentGateway(string $paymentMethod): PaymentGatewayInterface
    {
        switch ($paymentMethod) {
            case 'kashier':
                return new KashierPaymentGateway();
            case 'my-fatoora':
                return new MyFatooraPaymentGateway();
            default:
                throw new Exception('Unsupported payment method: ' . $paymentMethod);
        }
    }


}