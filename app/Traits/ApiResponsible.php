<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponsible
{
    private array $jsonResponse = [
        'success' => false,
        'message' => null,
    ];

    private int $statusCode = 0;
    private string|null $errorCode = null;

    // Format HTTP response in terms of JSend.
    protected function successResponse($responseKey = null, $message = 'Success', $data = null, $statusCode = 0): JsonResponse
    {
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['message'] = $message;

        $this->setResponseByResponseConfigKey($responseKey);

        !$data ?: $this->jsonResponse['data'] = $data;

        !$statusCode ?: $this->statusCode = $statusCode;

        return response()->json($this->jsonResponse, $this->statusCode);
    }

    protected function errorResponse($responseKey = null, $message = 'Error', $errors = null, $data = null, $statusCode = 0): JsonResponse
    {
        $this->jsonResponse['success'] = false;
        $this->jsonResponse['message'] = $message;

        $this->setResponseByResponseConfigKey($responseKey);

        !$errors ?: $this->jsonResponse['errors'] = $errors;
        !$data ?: $this->jsonResponse['data'] = $data;
        !$this->errorCode ?: $this->jsonResponse['code'] = $this->errorCode;

        !$statusCode ?: $this->statusCode = $statusCode;

        return response()->json($this->jsonResponse, $this->statusCode);
    }

    private function setResponseByResponseConfigKey($responseKey)
    {
        if ($responseKey) {
            $responseConfig = config("responses.$responseKey");

            if ($responseConfig) {
                !isset($responseConfig['status_code']) ?: $this->statusCode = $responseConfig['status_code'];
                !isset($responseConfig['error_code']) ?: $this->errorCode = $responseConfig['error_code'];
            }
        }
    }
}
