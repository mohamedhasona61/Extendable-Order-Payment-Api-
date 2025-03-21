<?php

namespace App\Services\Api\V1;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user= User::create($data);
        $user->token = JWTAuth::fromUser($user);
        return $user;
    }
    public function login(array $credentials): string
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new \Exception('Invalid credentials', 401);
        }
        return $token;
    }
    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
    public function refreshToken(): string
    {
        try {
            return JWTAuth::refresh(JWTAuth::getToken());
        } catch (JWTException $e) {
            throw new \Exception('Unable to refresh token', 500);
        }
    }
    public function getUser(): ?User
    {
        return JWTAuth::user();
    }
}