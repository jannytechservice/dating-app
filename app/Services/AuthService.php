<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user->createToken('authToken')->plainTextToken;
    }
}
