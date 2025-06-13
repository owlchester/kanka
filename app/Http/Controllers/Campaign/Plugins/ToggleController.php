<?php

namespace App\Http\Controllers\Campaign\Plugins;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Plugin;
use App\Services\Campaign\PluginService;

class ToggleController extends Controller
{
    protected PluginService $service;


    public function __construct(PluginService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $service;
    }

    public function enable(Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        $this->service->campaign($campaign)->user(auth()->user())->plugin($plugin)->enable();

        return redirect()->route('campaign_plugins.index', $campaign)
            ->with(
                'success',
                __('campaigns/plugins.enabled.success', ['plugin' => $plugin->name])
            );
    }

    public function disable(Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        $this->service->campaign($campaign)->user(auth()->user())->plugin($plugin)->disable();

        return redirect()->route('campaign_plugins.index', $campaign)
            ->with(
                'success',
                __('campaigns/plugins.disabled.success', ['plugin' => $plugin->name])
            );
    }
}
