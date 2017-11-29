<?php

namespace App\Observers;

use Stevebauman\Purify\Facades\Purify;

trait PurifiableTrait
{
    public function purify($text = '')
    {
        $config = ['HTML.Allowed' => 'big,small,h1,h2,h3,h4,h5,h6,img[src],div,ins,del,pre'];
        return Purify::clean($text, $config);
    }
}
