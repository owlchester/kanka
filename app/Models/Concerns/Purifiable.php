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
        $observer = app(PurifiableObserver::class);
        static::saving([$observer, 'saving']);
    }

    public function getPurifiableFields(): array
    {
        return $this->purifiableFields ?? ['entry'];
    }
}
