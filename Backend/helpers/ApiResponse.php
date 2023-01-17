<?php

namespace Helpers;

trait ApiResponse
{
    public static function response($data, $status = 200, $message = 'success')
    {
        http_response_code($status);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
