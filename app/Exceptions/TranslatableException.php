<?php

namespace App\Exceptions;

use Exception;

/**
 * Class TranslatableException
 * @package App\Exceptions
 *
 * App translatable exceptions
 */
class TranslatableException extends Exception
{
    /**
     * Translation options
     * @var array
     */
    public $options = [];

    /**
     */
    public function getTranslatedMessage(): string
    {
        return __($this->message, $this->options);
    }

    /**
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
