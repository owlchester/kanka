<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Module
 *
 * @see \App\Services\Submenus\SubmenuService
 *
 * @mixin \App\Services\Submenus\SubmenuService
 */
class Submenu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'submenu';
    }
}
