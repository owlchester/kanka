<?php

namespace App\Services;

class DomainService
{
    /**
     * Check if the request is for the app/backend
     * @return bool
     */
    public function isApp(): bool
    {
        return request()->host() ===  $this->app();
    }

    /**
     * Check if the request is for the api
     * @return bool
     */
    public function isApi(): bool
    {
        return request()->host() === $this->api();
    }

    /**
     * Check if the request is for the frontend
     * @return bool
     */
    public function isFront(): bool
    {
        return request()->host() === $this->front();
    }

    public function app(): string
    {
        return config('domains.app');
    }

    public function front(): string
    {
        return config('domains.front');
    }

    public function api(): string
    {
        return config('domains.api');
    }

    public function toFront(string $page): string
    {
        return '//' . $this->front() . '/' . $page;
    }
}
