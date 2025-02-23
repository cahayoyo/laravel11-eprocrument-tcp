<?php

namespace App\Helpers;

class ResponseFormatter
{
    // Template response
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    // Method untuk success response
    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    // Method untuk error response
    public static function error($message = null, $code = 400)
    {
        self::$response['meta']['code'] = $code;
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['message'] = $message;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
