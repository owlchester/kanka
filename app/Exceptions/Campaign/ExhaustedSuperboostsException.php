<?php

namespace App\Exceptions\Campaign;

use App\Exceptions\TranslatableException;
use Exception;
use Throwable;

class ExhaustedSuperboostsException extends TranslatableException
{
    public $trans = 'settings.boost.exceptions.exhausted_superboosts';
}
