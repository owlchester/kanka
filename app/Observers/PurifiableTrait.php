<?php

namespace App\Observers;

use Stevebauman\Purify\Facades\Purify;

/**
 * Trait PurifiableTrait
 * @package App\Observers
 */
trait PurifiableTrait
{
    /**
     * @param string $text
     * @return string
     */
    public function purify($text = '')
    {
        //dd('help');
        $purified = Purify::clean($text);

        // If it's really empty, zap it
        if ($purified == "\r\n\r\n") {
            return '';
        }

        return $purified;
    }
}
