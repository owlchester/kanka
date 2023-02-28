<?php

namespace App\Exceptions\Campaign;

use App\Exceptions\TranslatableException;

class ExhaustedSuperboostsException extends TranslatableException
{
    public $trans = 'settings.boost.exceptions.exhausted_superboosts';
}
