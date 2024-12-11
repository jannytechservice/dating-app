<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse
{
    public static function success(string $message, $data = null, $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'errors' => null,
        ], $statusCode);
    }

    public static function error(string $message, $errors = null, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
            'errors' => $errors,
        ], $statusCode);
    }
}
