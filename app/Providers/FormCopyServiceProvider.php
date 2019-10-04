<?php

namespace App\Providers;

use App\Services\FormCopyService;
use App\Services\MentionsService;
use Illuminate\Support\ServiceProvider;

/**
 * Class FormCopyServiceProvider
 * @package App\Providers
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
        $this->app->singleton(FormCopyService::class, function ($app) {
            return new FormCopyService();
        });

        //$this->app->alias(FormCopyService::class, 'formcopy');
    }
}
