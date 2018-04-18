<?php

namespace App\Observers;

use Stevebauman\Purify\Facades\Purify;

trait PurifiableTrait
{
    public function purify($text = '')
    {
        // Allowed HTML tags are set in config/purify.php
        return Purify::clean($text);
    }
}
