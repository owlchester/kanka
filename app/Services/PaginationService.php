<?php

namespace App\Services;

/**
 * Class PaginationService
 * @package App\Services
 */
class PaginationService
{
    public const MAX = 100;

    /**
     * List of available options for pagination
     * @return array
     */
    public function options(): array
    {
        $options = [
            null => 15,
            25 => 25,
            45 => 45,
            self::MAX => self::MAX
        ];

        if (!auth()->user()->isSubscriber()) {
            $options[self::MAX] = __('profiles.settings.helpers.pagination', ['amount' => self::MAX]);
        }

        return $options;
    }

    /**
     * Non-subscribers can see the max option, but can't select it
     * @return array
     */
    public function disabled(): array
    {
        $disabled = [];

        if (!auth()->user()->isSubscriber()) {
            $disabled[self::MAX] = ['disabled' => true];
        }

        return $disabled;
    }

    /**
     * Get the max pagination amount possible
     * @return int
     */
    public function max(): int
    {
        return auth()->check() && auth()->user()->isSubscriber() ? self::MAX : 45;
    }
}
