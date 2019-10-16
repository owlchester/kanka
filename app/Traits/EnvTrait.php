<?php

namespace App\Traits;

trait EnvTrait
{
    public function prod(): bool
    {
        return getenv('APP_ENV') === 'prod';
    }

    public function dev(): bool
    {
        return getenv('APP_ENV') === 'dev';
    }

    public function shadow(): bool
    {
        return getenv('APP_ENV') === 'shadow';
    }
}