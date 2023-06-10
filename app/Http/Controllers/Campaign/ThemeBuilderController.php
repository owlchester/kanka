<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreTheme;
use App\Http\Requests\ReorderStyles;
use App\Http\Requests\StoreCampaignStyle;
use App\Http\Requests\StoreCampaignTheme;
use App\Models\CampaignStyle;
use App\Services\Campaign\ThemeBuilderService;

class ThemeBuilderController extends Controller
{
    protected ThemeBuilderService $themeBuilderService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ThemeBuilderService $themeBuilderService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => 'index']);
        $this->themeBuilderService = $themeBuilderService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $style = CampaignStyle::theme()->first();
        $config = $style?->content;
        return view('campaigns.styles.builder', compact('campaign', 'config'));
    }

    public function save(StoreTheme $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $this->themeBuilderService
            ->campaign($campaign)
            ->save($request->get('config'));

        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/builder.success'));
    }


    public function reset()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $theme = $campaign->styles()->theme()->first();
        if (empty($theme)) {
            return redirect()
                ->route('campaign_styles.index');
        }
        $theme->delete();
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/builder.reset'));
    }

}
