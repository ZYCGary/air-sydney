<?php

namespace App\Http\Controllers\API;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Format HTTP response in terms of JSend.
    public function successResponse($data = null): JsonResponse
    {
        $jsonResponse = ['status' => 'success'];

        !$data ?: $jsonResponse['data'] = $data;

        return response()->json($jsonResponse);
    }

    public function failResponse($data = null): JsonResponse
    {
        $jsonResponse = ['status' => 'fail'];

        !$data ?: $jsonResponse['data'] = $data;

        return response()->json($jsonResponse);
    }

    public function errorResponse($message = null, $data = null, $code = null): JsonResponse
    {
        $jsonResponse = ['status' => 'error'];

        !$message ?: $jsonResponse['message'] = $message;
        !$data ?: $jsonResponse['data'] = $data;
        !$code ?: $jsonResponse['code'] = $code;

        return response()->json($jsonResponse);
    }
}
