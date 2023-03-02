<?php

namespace App\Exceptions\Campaign;

use App\Exceptions\TranslatableException;

class ExhaustedBoostsException extends TranslatableException
{
    public $trans = 'settings.boost.exceptions.exhausted_boosts';
}
