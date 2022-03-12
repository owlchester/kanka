<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignStyle;
use App\Http\Requests\StoreCampaignTheme;
use App\Models\Campaign;
use App\Models\CampaignStyle;
use App\Services\Campaign\UserService;

class StyleController extends Controller
{
    /** @var UserService */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => 'index']);
        $this->service = $userService;
    }

    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);
        $styles = $campaign->styles()->paginate();
        $theme = $campaign->theme;

        return view('campaigns.styles.index', compact('campaign', 'styles', 'theme'));
    }

    public function show(CampaignStyle $campaignStyle)
    {
        return redirect()
            ->route('campaign_styles.index');
    }

    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);
        return view('campaigns.styles.create', compact('campaign'));
    }

    public function store(StoreCampaignStyle $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $style = new CampaignStyle($request->only('name', 'content', 'is_enabled'));
        $style->campaign_id = $campaign->id;
        $style->save();
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.create.success'));
    }

    public function edit(CampaignStyle $campaignStyle)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $style = $campaignStyle;
        return view('campaigns.styles.edit', compact('campaign', 'style'));
    }

    public function update(StoreCampaignStyle $request, CampaignStyle $campaignStyle)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaignStyle->update($request->only('name', 'content', 'is_enabled'));
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.update.success', ['name' => $campaignStyle->name]));

    }

    public function destroy(CampaignStyle $campaignStyle)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaignStyle->delete();
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.delete.success', ['name' => $campaignStyle->name]));

    }

    public function theme()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $themes = [null => __('campaigns.themes.none')];
        foreach (\App\Models\Theme::all() as $theme) {
            $themes[$theme->id] = $theme->__toString();
        }

        return view('campaigns.styles.theme', compact('campaign', 'themes'));
    }

    public function themeSave(StoreCampaignTheme $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaign->update([
            'theme_id' => $request->get('theme_id')
        ]);

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.theme.success'))
        ;
    }
}
