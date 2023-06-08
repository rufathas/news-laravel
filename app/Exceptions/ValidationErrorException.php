<?php

namespace App\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{
    private array $messages;
    protected $code;

    public function __construct(array $messages, int $code, ?Throwable $previous = null)
    {
        $this->messages = $messages;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json(["messages" => $this->messages],$this->code);
    }
}
