<?php

namespace App\Services;

/**
 * Class PaginationService
 * @package App\Services
 */
class PaginationService
{
    public int $max = 45;
    public int $subMax = 100;

    /**
     * List of available options for pagination
     */
    public function options(): array
    {
        $options = [
            null => __('settings/appearance.values.pagination', ['amount' => 15]),
            25 => __('settings/appearance.values.pagination', ['amount' => 25]),
            45 => __('settings/appearance.values.pagination', ['amount' => 45]),
            $this->subMax => __('settings/appearance.values.pagination', ['amount' => $this->subMax])
        ];

        if (!auth()->user()->isSubscriber()) {
            $options[$this->subMax] = __('settings/appearance.values.pagination-sub', ['amount' => $this->subMax]);
        }

        return $options;
    }

    /**
     * Non-subscribers can see the max option, but can't select it
     */
    public function disabled(): array
    {
        $disabled = [];

        if (!auth()->user()->isSubscriber()) {
            $disabled[$this->subMax] = ['disabled' => true];
        }

        return $disabled;
    }

    /**
     * Get the max pagination amount possible
     */
    public function max(): int
    {
        return auth()->check() && auth()->user()->isSubscriber() ? $this->subMax : $this->max;
    }
}
