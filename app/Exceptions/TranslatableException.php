<?php

namespace App\Exceptions;

use Exception;
use Throwable;

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
     * @return string
     */
    public function getTranslatedMessage(): string
    {
        return __($this->message, $this->options);
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
