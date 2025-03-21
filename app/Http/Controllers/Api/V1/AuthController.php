<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\AuthService;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Requests\Api\V1\RegisterRequest;

class AuthController extends Controller
{
    use ApiResponse; 
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        return $this->successResponse(201, 'User registered successfully', new UserResource($user));
    }
    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());
        if (!$token) {
            return $this->errorResponse(401, 'Unauthorized');
        }
        return $this->successResponse(200, 'Login successful', ['token' => $token]);
    }
    public function logout()
    {
        $this->authService->logout();
        return $this->successResponse(200, 'Successfully logged out');
    }
    public function refresh()
    {
        $token = $this->authService->refreshToken();
        return $this->successResponse(200, 'Token refreshed successfully', ['token' => $token]);
    }
    public function me()
    {
        $user = $this->authService->getUser();
        return $this->successResponse(200, 'User details fetched successfully', new UserResource($user));
    }
}