<?php

namespace App\Models\Concerns;

use App\Observers\PurifiableObserver;

/**
 * @property ?string $entry
 */
trait Purifiable
{
    public static function bootPurifiable(): void
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }
        static::observe(app(PurifiableObserver::class));
    }

    public function getPurifiableFields(): array
    {
        return $this->purifiableFields ?? ['entry'];
    }
}
