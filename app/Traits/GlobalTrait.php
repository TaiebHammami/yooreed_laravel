<?php

namespace App\Traits;

trait GlobalTrait
{
    protected function globalResponse($message, $code, $data=null)
    {
        $jsonResponse = [
            'message' => $message,
        ];

        if ($data) {
            $jsonResponse['data'] = $data;
        }

        return response()->json($jsonResponse, $code);
    }
}
