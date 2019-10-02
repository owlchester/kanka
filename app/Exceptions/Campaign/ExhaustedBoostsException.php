<?php

namespace App\Exceptions\Campaign;

use App\Exceptions\TranslatableException;
use Exception;
use Throwable;

class ExhaustedBoostsException extends TranslatableException
{
    public $trans = 'campaigns.boost.exceptions.exhausted_boosts';
}
