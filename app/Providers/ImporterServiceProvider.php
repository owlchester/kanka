<?php

namespace App\Providers;

use App\Services\Campaign\Import\ImportIdMapper;
use Illuminate\Support\ServiceProvider;

class ImporterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImportIdMapper::class, function () {
            return new ImportIdMapper;
        });

        $this->app->alias(ImportIdMapper::class, 'importidmapper');
    }
}
