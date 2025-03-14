<?php

namespace App;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function success($data = null, string $message = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message, 
        ]);
    }

    public function error(string $message = null, string $erroCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => $erroCode,
                'message' => $message
            ]
        ]);
    }
}
