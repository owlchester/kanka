<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Plugin;
use App\Models\PluginVersion;
use App\Services\Campaign\CampaignPluginService;
use App\Services\EntityService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignPluginController extends Controller
{
    /** @var CampaignPluginService */
    protected $service;

    public function __construct(CampaignPluginService $service)
    {
        $this->middleware('auth', ['except' => 'css']);
        $this->middleware('campaign.boosted', ['except' => 'index']);

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $plugins = $campaign->plugins()->paginate();
        return view('campaigns.plugins', compact('campaign', 'plugins'));
    }

    /**
     * @param Plugin $plugin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function enable(Plugin $plugin)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $this->service->campaign($campaign)->plugin($plugin)->enable();

        return redirect()->route('campaign_plugins.index')
            ->with(
                'success',
                __('campaigns/plugins.enabled.success', ['plugin' => $plugin->name])
            );
    }

    /**
     * @param Plugin $plugin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function disable(Plugin $plugin)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $this->service->campaign($campaign)->plugin($plugin)->disable();

        return redirect()->route('campaign_plugins.index')
            ->with(
                'success',
                __('campaigns/plugins.disabled.success', ['plugin' => $plugin->name])
            );
    }


    /**
     * @param Request $request
     * @param Plugin $plugin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Plugin $plugin)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        try {
            $this->service->campaign($campaign)->plugin($plugin)->remove();

            return redirect()->route('campaign_plugins.index')
                ->with(
                    'success',
                    __('campaigns/plugins.destroy.success', ['plugin' => $plugin->name])
                );
        } catch (\Exception $e) {
            return redirect()->route('campaign_plugins.index')
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function css()
    {
        $campaign = CampaignLocalization::getCampaign();

        $themes = CampaignCache::themes();

        $response = \Illuminate\Support\Facades\Response::make($themes);
        $response->header('Content-Type', 'text/css');
        $response->header('Expires', Carbon::now()->addMonth(1)->toDateTimeString());
        $month = 2592000;
        $response->header('Cache-Control', 'public, max_age=' . $month);

        return $response;
    }

    /**
     * @param Plugin $plugin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateInfo(Plugin $plugin)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $ajax = request()->ajax();
        $versions = $plugin->versions()->publishedVersions($plugin->created_by)->orderBy('id', 'desc')->paginate();

        $plugin = $campaign->plugins->where('id', $plugin->id)->first();

        return view('campaigns.plugins.info', compact('plugin', 'ajax', 'versions'));
    }

    /**
     * @param Plugin $plugin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Plugin $plugin)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $this->service->plugin($plugin)->campaign($campaign)->update();
        return redirect()->route('campaign_plugins.index')
            ->with(
                'success',
                __('campaigns/plugins.update.success', ['plugin' => $plugin->name])
            );

    }

}
