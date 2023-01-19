<?php

namespace App\Services;

/**
 * Class PaginationService
 * @package App\Services
 */
class PaginationService
{
    public static int $MAX = 100;

    /**
     * @return array
     */
    public function options()
    {
        $options = [
            null => 15,
            25 => 25,
            45 => 45
        ];

        if (auth()->check() && auth()->user()->isSubscriber()) {
            $options[self::$MAX] = self::$MAX;
        }

        return $options;
    }

    /**
     * Get the max pagination amount possible
     * @return int
     */
    public function max(): int
    {
        return auth()->check() && auth()->user()->isSubscriber() ? self::$MAX : 45;
    }
}
