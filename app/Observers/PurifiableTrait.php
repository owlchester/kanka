<?php

namespace App\Observers;

use Stevebauman\Purify\Facades\Purify;

trait PurifiableTrait
{
    public function purify($text = '')
    {
        $config = [
            'HTML.Allowed' =>
                'big,small,h1,h2,h3,h4,h5,h6,img[src|style|alt|width|height],div,ins,del,pre,a[href|target],strong,em,s,u,ul,ol,li,p,'
                . 'blockquote,sup,sub,'
                . 'table[style|border|cellpadding|cellspacing],tbody,thead,tfoot,tr[style],td[style],hr,caption'
        ];

        return Purify::clean($text, $config);
    }
}
