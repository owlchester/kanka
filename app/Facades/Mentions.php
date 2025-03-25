<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Mentions
 *
 * @see \App\Services\MentionsService
 *
 * @mixin \App\Services\MentionsService
 */
class Mentions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mentions';
    }
}
