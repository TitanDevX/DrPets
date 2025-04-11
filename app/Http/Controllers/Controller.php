<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function res(mixed $data = [], string $message = 'success', int $code = 200)
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data], $code);  
    }
}
