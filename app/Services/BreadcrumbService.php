<?php

namespace App\Services;

use App\Traits\CampaignAware;

class BreadcrumbService
{
    use CampaignAware;

    /**
     * @param string $name
     * @return string
     */
    public function index(string $name): string
    {
        // Determine the "mode" for logged in users who prefer the old table view
        $params = auth()->check() && auth()->user()->entityExplore === '1' ? ['m' => 'table'] : [];
        $params['campaign'] = $this->campaign;

        // If the user activated nested views by default, go back to it.
        $entityIndexRoute = route($name . '.index', $params);
        if ($this->campaign->defaultToNested() || (auth()->check() && auth()->user()->defaultNested)) {
            if (\Illuminate\Support\Facades\Route::has($name . '.tree')) {
                $entityIndexRoute = route($name . '.tree', $params);
            }
        }

        return $entityIndexRoute;
    }
}
