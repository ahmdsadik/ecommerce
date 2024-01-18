<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function successResponse($data, $code = 200): JsonResponse
    {
        return response()->json(
            [
                'data' => $data,
                'status' => in_array($code, $this->successCode()),
                'statusCode' => $code
            ], $code
        );
    }

    public function errorResponse($message, $code = 404): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'status' => !in_array($code, $this->errorCode()),
                'statusCode' => $code
            ], $code
        );
    }

    private function successCode(): array
    {
        return [
            200, 201, 202
        ];
    }

    private function errorCode(): array
    {
        return [
            400, 401, 404, 422, 500
        ];
    }

}
