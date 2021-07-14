<?php


namespace App\Models\Concerns;


use App\Observers\EntityLogObserver;

trait EntityLogs
{
    protected $hasUpdateLog = true;

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
        static::observe(app(EntityLogObserver::class));
    }
}
