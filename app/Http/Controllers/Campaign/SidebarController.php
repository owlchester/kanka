<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\SidebarService;

class SidebarController extends Controller
{
    protected SidebarService $service;

    public function __construct(SidebarService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => 'index']);

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $layout = $this->service->campaign($campaign)->withDisabled()->layout();

        return view(
            'campaigns.sidebar.index',
            compact(
                'campaign',
                'layout'
            )
        );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        // Good luck
        $this->service->campaign($campaign)
            ->save(request()->all());

        return redirect()
            ->route('campaign-sidebar', $campaign)
            ->with('success', __('campaigns/sidebar.success'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reset(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->service->campaign($campaign)->reset();

        return redirect()
            ->route('campaign-sidebar', $campaign)
            ->with('success', __('campaigns/sidebar.reset.success'));
    }
}
