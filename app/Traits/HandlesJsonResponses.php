<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HandlesJsonResponses
{
    public function successResponse($data, $message = "Operation Successful", $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            "success" => true,
            "data" => $data,
            "message" => $message
        ];
        return response()->json($response, $statusCode);
    }

    public function success($message = "Operation Successful", $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            "success" => true,
            "message" => $message
        ];
        return response()->json($response, $statusCode);
    }

    public function errorResponse($data = null, $message = null, $statusCode = Response::HTTP_BAD_REQUEST, $e = null): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }

    public function error($message = 'Operation Failed', $statusCode = Response::HTTP_BAD_REQUEST, $e = null): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
        ], $statusCode);
    }

}
