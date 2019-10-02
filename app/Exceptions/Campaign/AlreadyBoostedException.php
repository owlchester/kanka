<?php

namespace App\Exceptions\Campaign;

use App\Exceptions\TranslatableException;
use Exception;

class AlreadyBoostedException extends TranslatableException
{
    public $trans = 'campaigns.boost.exceptions.already_boosted';
}
