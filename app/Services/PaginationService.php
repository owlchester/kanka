<?php

namespace App\Services;

/**
 * Class PaginationService
 * @package App\Services
 */
class PaginationService
{
    public static $MAX = 100;

    /**
     * @return array
     */
    public function options()
    {
        $options = [
            15 => 15,
            25 => 25,
            45 => 45
        ];

        if (auth()->check() && auth()->user()->isPatron()) {
            $options[self::$MAX] = self::$MAX;
        }

        return $options;
    }

    /**
     * Get the max amount possible
     * @return int
     */
    public function max()
    {
        return auth()->check() && auth()->user()->isPatron() ? self::$MAX : 45;
    }
}
