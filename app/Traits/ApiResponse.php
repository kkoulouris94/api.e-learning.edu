<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function response;

trait ApiResponse
{
    public function successResponse($data, $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json(['data' => $data], $code);
    }

    public function errorResponse($message, $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
