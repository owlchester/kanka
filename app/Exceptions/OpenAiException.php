<?php

namespace App\Exceptions;

use Exception;

class OpenAiException extends Exception
{
    protected $context;

    public function getContext()
    {
        return $this->context;
    }

    public function setContext($context)
    {
        $this->context = $context;
    }
}
