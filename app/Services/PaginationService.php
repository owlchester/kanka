<?php

namespace App\Services;

use App\Traits\UserAware;
use Illuminate\Support\Arr;

/**
 * Class PaginationService
 */
class PaginationService
{
    use UserAware;

    protected array $options = [
        15,
        25,
        45,
        100,
    ];

    protected int $nonSubscriberMax = 45;

    /**
     * List of available options for pagination
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Options that require a subscription
     */
    public function subscriberOnlyOptions(): array
    {
        return array_values(array_filter($this->options, fn ($v) => $v > $this->nonSubscriberMax));
    }

    /**
     * Get the max pagination amount possible
     */
    public function max(): int
    {
        return isset($this->user) && $this->user->isSubscriber() ? Arr::last($this->options) : $this->nonSubscriberMax;
    }
}
