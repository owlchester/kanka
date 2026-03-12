<?php

namespace App\Facades;

use App\Services\MentionsService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Mentions
 *
 * @see MentionsService
 *
 * @mixin MentionsService
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
