<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Mockery;

class AuthServiceTest extends TestCase
{
    protected $authService;
    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->authService = new AuthService($this->userRepository);
    }

    /**
     * Test user registration.
     */
    public function test_register_user_successfully()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        $this->userRepository->shouldReceive('createUser')
            ->once()
            ->with(Mockery::on(function ($input) {
                return isset($input['password']) && Hash::check('password123', $input['password']);
            }))
            ->andReturn((object) $data);

        $result = $this->authService->register($data);

        $this->assertEquals('johndoe@example.com', $result->email);
    }

    /**
     * Test login with valid credentials.
     */
    public function test_login_successfully()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);
    
        $this->userRepository->shouldReceive('findByEmail')
            ->once()
            ->with($user->email)
            ->andReturn($user);
    
        $result = $this->authService->login([
            'email' => $user->email,
            'password' => 'password123',
        ]);
    
        $this->assertNotNull($result);
    }
    

    /**
     * Test login with invalid credentials.
     */
    public function test_login_with_invalid_credentials()
    {
        $user = User::factory()->make(['password' => bcrypt('password123')]);

        $this->userRepository->shouldReceive('findByEmail')
            ->once()
            ->with('johndoe@example.com')
            ->andReturn($user);

        $result = $this->authService->login([
            'email' => 'johndoe@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertNull($result);
    }

    /**
     * Test finding a user by email.
     */
    public function test_find_user_by_email()
    {
        $user = User::factory()->make(['email' => 'johndoe@example.com']);

        $this->userRepository->shouldReceive('findByEmail')
            ->once()
            ->with('johndoe@example.com')
            ->andReturn($user);

        $result = $this->authService->findByEmail('johndoe@example.com');

        $this->assertEquals('johndoe@example.com', $result->email);
    }
}
