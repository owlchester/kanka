<?php

namespace App\Observers;

use Stevebauman\Purify\Facades\Purify;

trait PurifiableTrait
{
    public function purify($text = '')
    {
        $purified = Purify::clean($text);

        // If it's really empty, zap it
        if ($purified == "\r\n\r\n") {
            return '';
        }
        dump($text);
        dd($purified);

        return $purified;
    }
}
