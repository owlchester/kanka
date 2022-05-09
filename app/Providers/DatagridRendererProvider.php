<?php

namespace App\Providers;

use App\Renderers\DatagridRenderer2;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class DatagridRendererProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias(DatagridRenderer2::class, 'datagrid');
    }
}
