<?php

namespace App\Services;

use App\Traits\RequestAware;

class DomainService
{
    use RequestAware;

    /**
     * Check if the request is for the app/backend
     */
    public function isApp(): bool
    {
        return $this->request->host() === $this->app();
    }

    /**
     * Check if the request is for the api
     */
    public function isApi(): bool
    {
        return $this->request->is('api/*') || $this->request->host() === $this->api();
    }

    /**
     * Check if the request is for the frontend
     */
    public function isFront(): bool
    {
        return $this->request->host() === $this->front();
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

    public function importer(): string
    {
        return config('domains.importer');
    }

    public function toFront(string $page): string
    {
        return '//' . $this->front() . '/' . $page;
    }
}
