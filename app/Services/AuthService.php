<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 *
 * This service handles user authentication and registration.
 */
class AuthService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Register a new user.
     *
     * @param array<string, string> $data
     * @return mixed
     */
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    /**
     * Authenticate a user and generate a token.
     *
     * @param array<string, string> $credentials
     * @return string|null
     */
    public function login(array $credentials)
    {
        /** @var User | null $user */
        $user = $this->userRepository->findByEmail($credentials['email']);
        if ($user === null || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user->createToken('authToken')->plainTextToken;
    }
}
