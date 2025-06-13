<?php

namespace App\Services;

use App\Traits\UserAware;

/**
 * Class PaginationService
 */
class PaginationService
{
    use UserAware;

    public const MAX = 100;

    /**
     * List of available options for pagination
     */
    public function options(): array
    {
        $options = [
            null => __('settings/appearance.values.pagination', ['amount' => 15]),
            25 => __('settings/appearance.values.pagination', ['amount' => 25]),
            45 => __('settings/appearance.values.pagination', ['amount' => 45]),
            self::MAX => __('settings/appearance.values.pagination', ['amount' => self::MAX]),
        ];

        if (! $this->user->isSubscriber()) {
            $options[self::MAX] = __('settings/appearance.values.pagination-sub', ['amount' => self::MAX]);
        }

        return $options;
    }

    /**
     * Non-subscribers can see the max option, but can't select it
     */
    public function disabled(): array
    {
        $disabled = [];

        if (! $this->user->isSubscriber()) {
            $disabled[self::MAX] = ['disabled' => true];
        }

        return $disabled;
    }

    /**
     * Get the max pagination amount possible
     */
    public function max(): int
    {
        return isset($this->user) && $this->user->isSubscriber() ? self::MAX : 45;
    }
}
