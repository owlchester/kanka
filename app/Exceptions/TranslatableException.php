<?php

namespace App\Exceptions;

use Exception;

/**
 * Class TranslatableException
 */
class TranslatableException extends Exception
{
    /**
     * Translation options
     *
     * @var array
     */
    public $options = [];

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
