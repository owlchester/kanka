<?php

namespace App\Http\Controllers\Campaign\Plugins;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Campaigns\Boosted;
use App\Models\Campaign;
use App\Models\Plugin;
use App\Services\Campaign\PluginService;

class ToggleController extends Controller
{
    public function __construct(protected PluginService $service)
    {
        $this->middleware(['auth', Boosted::class]);
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
