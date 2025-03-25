<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
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
        $this->app->singleton(DatagridRenderer2::class, function () {
            $service = new DatagridRenderer2;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });

        $this->app->alias(DatagridRenderer2::class, 'datagrid');
    }
}
