<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'name', 'email']]);
    }
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['token']]);
    }
    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        // Login to get a token
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $token = $loginResponse->json()['data']['token'];

        // Logout using the token
        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');
        $logoutResponse->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);

        // Verify the token is invalidated
        $meResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');
        $meResponse->assertStatus(200);
    }
    public function test_user_can_refresh_token()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Login to get a token
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $token = $loginResponse->json()['data']['token'];

        // Refresh the token
        $refreshResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/refresh');

        // Assert the response
        $refreshResponse->assertStatus(200)
            ->assertJsonStructure(['data' => ['token']]);

        // Verify the new token works
        $newToken = $refreshResponse->json()['data']['token'];

        $meResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $newToken,
        ])->getJson('/api/me');

        $meResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'user' => [
                        'email' => 'test@example.com',
                    ],
                ],
            ]);
    }
    public function test_user_can_get_their_details()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $token = $loginResponse->json('data.token');
        $meResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');
        $meResponse->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ],
        ])->assertJson([
            'data' => [
                'user' => [
                    'email' => 'test@example.com',
                ],
            ],
        ]);
    }
}
