<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ArrayException extends Exception
{
    protected $messages;

    public function __construct(array $messages, $code = 0, Throwable $previous = null)
    {
        parent::__construct(json_encode($messages), $code, $previous);

        $this->messages = $messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
