<?php

namespace App\Facades;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Dashboard
 *
 * @mixin DashboardService
 *
 * @see DashboardService
 */
class Dashboard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dashboard';
    }
}
