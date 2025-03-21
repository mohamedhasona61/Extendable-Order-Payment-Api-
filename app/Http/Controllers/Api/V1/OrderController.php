<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\OrderService;
use App\Http\Requests\Api\V1\OrderRequest;

class OrderController extends Controller
{
    use ApiResponse;
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function createOrder(OrderRequest $request): JsonResponse
    {
        $result = $this->orderService->createOrder($request->validated());
        if (isset($result['success']) && !$result['success']) {
            return $this->errorResponse(500,$result['message']);
        }
        return $this->successResponse(201, 'Order created successfully', $result['data']);
    }

    public function cancelOrder(OrderRequest $request): JsonResponse
    {
        $result = $this->orderService->cancelOrder($request->validated());
        if (isset($result['success']) && !$result['success']) {
            return $this->errorResponse(500,$result['message']);
        }
        return $this->successResponse(201, 'Order cancelled successfully', $result['data']);
    }

}