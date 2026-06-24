<?php

namespace App\Models\Concerns;

use App\Observers\EntityLogObserver;

trait EntityLogs
{
    protected bool $hasUpdateLog = true;

    public function withoutUpdateLog(): self
    {
        $this->hasUpdateLog = false;

        return $this;
    }

    public function hasUpdateLog(): bool
    {
        return $this->hasUpdateLog;
    }

    /**
     * Boot the trait's observers
     */
    public static function bootEntityLogs(): void
    {
        // Don't add this observer if in console mode
        if (app()->runningInConsole()) {
            return;
        }
        $observer = app(EntityLogObserver::class);
        static::created([$observer, 'created']);
        static::updated([$observer, 'updated']);
        static::deleted([$observer, 'deleted']);
        static::restored([$observer, 'restored']);
    }
}
