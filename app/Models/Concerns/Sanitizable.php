<?php

namespace App\Models\Concerns;

use App\Observers\SanitizedObserver;

/**
 * @package App\Models\Concerns
 * @property array $sanitizable
 */
trait Sanitizable
{
    /**
     * Boot the trait's observers
     */
    public static function bootSanitizable(): void
    {
        static::observe(app(SanitizedObserver::class));
    }

    public function getSanitizable(): array
    {
        if (!property_exists($this, 'sanitizable')) {
            return [];
        }
        return $this->sanitizable;
    }
}
