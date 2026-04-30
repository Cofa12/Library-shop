<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class QuantityException extends Exception
{
    public function __construct(string $message = "Book quantity is not enough")
    {
        parent::__construct($message);
    }

    public function render($request, $exception)
    {
        return response()->json([
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ], Response::HTTP_BAD_REQUEST);
    }
}