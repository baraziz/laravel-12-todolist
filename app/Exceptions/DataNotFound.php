<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DataNotFound extends Exception
{
    public function __construct($message)
    {
        $this->message = $message;
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            "message" => $this->message,
        ], 404);
    }
}
