<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse as BaseJsonResponse;

class JsonResponse
{
    /**
     * Returns a success JSON response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(string $message, mixed $data = null, int $statusCode = Response::HTTP_OK): BaseJsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'errors' => null,
        ], $statusCode);
    }

    /**
     * Returns an error JSON response.
     *
     * @param string $message
     * @param mixed|null $errors
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(string $message, mixed $errors = null, int $statusCode = Response::HTTP_BAD_REQUEST): BaseJsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
            'errors' => $errors,
        ], $statusCode);
    }
}
