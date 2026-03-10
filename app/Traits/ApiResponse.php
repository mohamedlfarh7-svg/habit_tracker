<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Success Response
     */
    protected function successResponse($data, string $message = 'Opération réussie', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ], $code);
    }

    /**
     * Error Response
     */
    protected function errorResponse(string $message = 'Erreur', int $code = 422, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors'  => $errors,
            'message' => $message,
        ], $code);
    }
}