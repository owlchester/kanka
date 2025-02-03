<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     */
    protected $except = [
        'kanka_locale',
        'kanka_trusted_domains', // used for the trusted domains entity links that is set in javascript
        'toggleState', // used to determine if the sidebar is collapsed or not
    ];
}
