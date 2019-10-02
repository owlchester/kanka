<?php

namespace App\Exceptions\Campaign;

use App\Exceptions\TranslatableException;
use App\Models\Campaign;
use Exception;
use Throwable;

class AlreadyBoostedException extends TranslatableException
{
    public $trans = 'settings.boost.exceptions.already_boosted';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->options = ['name' => $message->name];
        parent::__construct('', $code, $previous);
    }
}
