<?php

namespace App\Facades;

use App\Services\Images\AvatarService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Avatar
 *
 * @see AvatarService
 *
 * @mixin AvatarService
 */
class Avatar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'avatar';
    }
}
