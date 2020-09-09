<?php


namespace App\Models\Concerns;


use App\Observers\UuidObserver;

/**
 * Class Uuid
 * @package App\Models\Concerns
 *
 * @property string $uuid
 */
trait Uuid
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }


    /**
     * Boot the trait's observers
     */
    public static function bootUuid(): void
    {
        static::observe(app(UuidObserver::class));
    }
}
