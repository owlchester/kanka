<?php

namespace App\Models\Concerns;

use App\Observers\SanitizedObserver;

/**
 * @property array $sanitizable
 */
trait Sanitizable
{
    /**
     * Boot the trait's observers
     */
    public static function bootSanitizable(): void
    {
        $observer = app(SanitizedObserver::class);
        static::saving([$observer, 'saving']);
    }

    public function getSanitizable(): array
    {
        if (! property_exists($this, 'sanitizable')) {
            return [];
        }

        return $this->sanitizable;
    }
}
