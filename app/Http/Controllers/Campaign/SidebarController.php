<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Services\SidebarService;

class SidebarController extends Controller
{
    /** @var SidebarService */
    protected $service;

    public function __construct(SidebarService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => 'index']);

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $layout = $this->service->campaign($campaign)->withDisabled()->layout();

        return view('campaigns.sidebar.index', compact(
            'campaign', 'layout')
        );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        // Good luck
        $this->service->campaign($campaign)
            ->save(request()->all());

        return redirect()
            ->route('campaign-sidebar')
            ->with('success', __('campaigns/sidebar.success'))
        ;

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reset()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $this->service->campaign($campaign)->reset();

        return redirect()
            ->route('campaign-sidebar')
            ->with('success', __('campaigns/sidebar.reset.success'))
        ;

    }
}
