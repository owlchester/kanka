<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreTheme;
use App\Models\Campaign;
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
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $style = CampaignStyle::theme()->first();
        $config = $style?->content;

        return view('campaigns.styles.builder', compact('campaign', 'config'));
    }

    public function save(StoreTheme $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->themeBuilderService
            ->campaign($campaign)
            ->save($request->get('config'));

        CampaignCache::clearStyles()->clear();

        return redirect()
            ->route('campaign_styles.index', $campaign)
            ->with('success', __('campaigns/builder.success'));
    }

    public function reset(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $theme = $campaign->styles()->theme()->first();
        if (empty($theme)) {
            return redirect()
                ->route('campaign_styles.index', $campaign);
        }
        $theme->delete();
        CampaignCache::clearStyles()->clear();

        return redirect()
            ->route('campaign_styles.index', $campaign)
            ->with('success', __('campaigns/builder.reset'));
    }
}
