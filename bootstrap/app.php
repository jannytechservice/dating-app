<?php

use App\Helpers\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle ValidationException globally
        $exceptions->render(function (ValidationException $exception, Request $request) {
            Log::channel('validation')->warning('Validation failed', [
                'errors' => $exception->errors(),
                'url' => $request->fullUrl(),
                'user_id' => $request->user() ? $request->user()->id : null,
            ]);
            return JsonResponse::error(
                'Validation failed.',
                $exception->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        });
        // Handle AuthenticationException globally
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            Log::channel('info')->info('Unauthenticated access attempt', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);
            return JsonResponse::error(
                'Unauthenticated.',
                null,
                Response::HTTP_UNAUTHORIZED
            );
        });
        // Handle AuthorizationException globally
        $exceptions->render(function (AuthorizationException $exception, Request $request) {
            Log::channel('error')->error('Unauthorized action', [
                'url' => $request->fullUrl(),
                'user_id' => $request->user() ? $request->user()->id : null,
            ]);
            return JsonResponse::error(
                'Unauthorized.',
                null,
                Response::HTTP_FORBIDDEN
            );
        });
        // Handle generic Throwable exceptions (500 errors)
        $exceptions->render(function (Throwable $exception, Request $request) {
            Log::channel('error')->error('Internal server error', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
                'url' => $request->fullUrl(),
                'user_id' => $request->user() ? $request->user()->id : null,
            ]);
            if (app()->environment('production')) {
                // In production, return a generic error to avoid exposing sensitive data
                return JsonResponse::error(
                    'An unexpected error occurred.',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
            // In non-production environments, include exception details for debugging
            return JsonResponse::error(
                $exception->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        });
    })->create();
