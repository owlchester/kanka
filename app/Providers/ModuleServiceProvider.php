<?php

namespace App\Providers;

use App\Services\Campaign\ModuleService;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(ModuleService::class);
        $this->app->alias(ModuleService::class, 'module');
    }
}
