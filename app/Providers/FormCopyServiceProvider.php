<?php

namespace App\Providers;

use App\Services\FormCopyService;
use Illuminate\Support\ServiceProvider;

/**
 * Class FormCopyServiceProvider
 */
class FormCopyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FormCopyService::class, function () {
            return new FormCopyService;
        });

        // $this->app->alias(FormCopyService::class, 'formcopy');
    }
}
