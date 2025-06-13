<?php

namespace App\Http\Controllers\Campaign\Plugins;

use App\Facades\CampaignCache;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Plugin;
use App\Services\Campaign\PluginService;
use Exception;
use Illuminate\Http\Request;

class BulkController extends Controller
{
    protected PluginService $service;

    public function __construct(PluginService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $action = request()->get('action');
        $models = request()->get('model');
        if (! in_array($action, ['enable', 'disable', 'update', 'delete']) || empty($models)) {
            return redirect()
                ->route('campaign_plugins.index', $campaign);
        }

        $this->service->campaign($campaign)->user(auth()->user());
        $count = 0;
        foreach ($models as $id) {
            /** @var Plugin|null $plugin */
            $plugin = Plugin::find($id);
            if (empty($plugin)) {
                continue;
            }
            if ($action === 'enable') {
                if ($this->service->plugin($plugin)->enable()) {
                    $count++;
                }
            } elseif ($action === 'disable') {
                if ($this->service->plugin($plugin)->disable()) {
                    $count++;
                }
            } elseif ($action === 'update') {
                if ($this->service->plugin($plugin)->update()) {
                    $count++;
                }
            } elseif ($action === 'delete') {
                $this->service->plugin($plugin)->remove();
                $count++;
            }
        }
        CampaignCache::clearTheme();

        return redirect()
            ->route('campaign_plugins.index', $campaign)
            ->with('success', trans_choice('campaigns/plugins.bulks.' . $action, $count, ['count' => $count]));
    }
}
