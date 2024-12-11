<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_register_user_successfully()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => ['id', 'name', 'email', 'created_at'],
                     'errors',
                 ]);

        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    /**
     * Test user login with valid credentials.
     *
     * @return void
     */
    public function test_login_user_successfully()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $payload = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => ['token'],
                     'errors',
                 ]);
    }

    /**
     * Test login failure with invalid credentials.
     *
     * @return void
     */
    public function test_login_user_with_invalid_credentials()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $payload = [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(401)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Invalid credentials',
                 ]);
    }

    /**
     * Test login failure with non-existent email.
     *
     * @return void
     */
    public function test_login_user_with_nonexistent_email()
    {
        $payload = [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'User not found.',
                 ]);
    }
}
