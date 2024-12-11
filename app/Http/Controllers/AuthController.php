<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Services\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Constructor
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        return JsonResponse::success('User registered successfully', $user, Response::HTTP_CREATED);
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = $this->authService->findByEmail($request['email']);
        if (!$user) {
            return JsonResponse::error(
                'User not found.',
                ['email' => ['No user found with this email address.']],
                Response::HTTP_NOT_FOUND
            );
        }

        $token = $this->authService->login($request->validated());

        if (!$token) {
            return JsonResponse::error('Invalid credentials', ['password' => ['Wrong password.']], Response::HTTP_UNAUTHORIZED);
        }

        return JsonResponse::success('Login successful', ['token' => $token], Response::HTTP_OK);
    }
}
