<?php

namespace App\Http\Controllers\Campaign\Plugins;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Plugin;
use App\Services\Campaign\PluginService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    protected PluginService $service;

    public function __construct(PluginService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $service;
    }

    public function index(Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        $versions = $plugin
            ->versions()
            ->publishedVersions($plugin->created_by)
            ->orderBy('id', 'desc')
            ->paginate();

        $plugin = $campaign->plugins->where('id', $plugin->id)->first();

        return view('campaigns.plugins.info', compact('plugin', 'campaign', 'versions'));
    }

    public function update(Request $request, Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        if ($request->ajax()) {
            return response()->json();
        }

        $this->service->plugin($plugin)->campaign($campaign)->update();

        return redirect()->route('campaign_plugins.index', $campaign)
            ->with(
                'success',
                __('campaigns/plugins.update.success', ['plugin' => $plugin->name])
            );
    }
}
