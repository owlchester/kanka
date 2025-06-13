<?php

namespace App\Http\Controllers\Campaign\Plugins;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Plugin;
use App\Services\Plugins\ImporterService;
use Exception;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __construct(protected ImporterService $importerService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');
    }

    public function index(Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        $version = CampaignPlugin::where('campaign_id', $campaign->id)
            ->where('plugin_id', $plugin->id)
            ->firstOrFail();

        return view('campaigns.plugins.confirm')
            ->with('plugin', $plugin)
            ->with('campaign', $campaign)
            ->with('version', $version);
    }

    public function process(Request $request, Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        if ($request->ajax()) {
            return response()->json();
        }

        try {
            $count = $this->importerService
                ->plugin($plugin)
                ->campaign($campaign)
                ->user($request->user())
                ->options($request->only(['force_private', 'only_new']))
                ->import();

            return redirect()->route('campaign_plugins.index', $campaign)
                ->with(
                    'success',
                    trans_choice('campaigns/plugins.import.success', $count, ['plugin' => $plugin->name, 'count' => $count])
                )
                ->with('plugin_entities_created', $this->importerService->created())
                ->with('plugin_entities_updated', $this->importerService->updated())
                ->with('plugin_only_new', $request->get('only_new'));
        } catch (Exception $e) {
            return redirect()->route('campaign_plugins.index', $campaign)
                ->withError(__('campaigns/plugins.import.errors.' . $e->getMessage(), ['plugin' => $plugin->name]));
        }
    }
}
