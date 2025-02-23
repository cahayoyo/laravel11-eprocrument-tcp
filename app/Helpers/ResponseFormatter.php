<?php

namespace App\Helpers;

class ResponseFormatter
{
    // Template response
    protected static $response = [
        'meta' => [
            'code' => null,
            'status' => null,
            'message' => null,
        ],
        'data' => null,
    ];

    // Method untuk success response
    public static function success($data = null, $message = null, $code = null, $status = 'success')
    {
        // Set code, message, dan data
        self::$response['meta']['code'] = $code;
        self::$response['meta']['status'] = $status;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, $code);
    }

    // Method untuk error response
    public static function error($message = null, $code = null, $status = 'error')
    {
        // Set code dan message
        self::$response['meta']['code'] = $code;
        self::$response['meta']['status'] = $status;
        self::$response['meta']['message'] = $message;

        // Reset data ke null
        self::$response['data'] = null;

        return response()->json(self::$response, $code);
    }
}
