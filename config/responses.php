<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error Responses
    |--------------------------------------------------------------------------
    |
    | Status code | Description
    | 200         | OK
    | 201         | Created
    | 202         | Accepted
    | 204         | No Content
    |
    */

    'register_success' => [
        'status_code' => 201,
    ],

    'login_success' => [
        'status_code' => 200,
    ],

    'logout_success' => [
        'status_code' => 204,
    ],

    'create_success' =>[
        'status_code' => 201,
    ],

    'update_success' =>[
        'status_code' => 200,
    ],

    'delete_success' => [
        'status_code' => 204,
    ],


    /*
    |--------------------------------------------------------------------------
    | Error Responses
    |--------------------------------------------------------------------------
    |
    | Status code | Description
    | 400         | Bad Request
    | 401         | Unauthorized
    | 403         | Forbidden
    | 404         | Not Found
    | 410         | Gone
    | 422         | Unprocessable Entity
    | 429         | Too Many Request
    | 500         | Internal Server Error
    | 510         | External Error
    |
    */

    'invalid_input' => [
        'status_code' => 422,
        'error_code' => '0422'
    ],

    'login_fail' => [
        'status_code' => 401,
        'error_code' => '0401'
    ],

    'forbidden'=>[
        'status_code' => 403,
        'error_code' => '0403'
    ],

    'not_found' => [
        'status_code' => 404,
        'error_code' => '0404'
    ],

    'internal_error' => [
        'status_code' => 500,
        'error_code' => '0500'
    ]
];
