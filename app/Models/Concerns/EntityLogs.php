<?php


namespace App\Models\Concerns;


use App\Observers\EntityLogObserver;

trait EntityLogs
{
    /**
     * Boot the trait's observers
     */
    public static function bootEntityLogs(): void
    {
        static::observe(app(EntityLogObserver::class));
    }
}
