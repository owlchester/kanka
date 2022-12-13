<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsLayout;
use App\Services\PaginationService;
use Illuminate\Support\Facades\Auth;

class AppearanceController extends Controller
{
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PaginationService $paginationService)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $paginationService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $highlight = request()->get('highlight');
        return view('settings.layout')
            ->with('pagination', $this->service)
            ->with('highlight', $highlight);
    }

    /**
     * @param StoreSettingsLayout $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreSettingsLayout $request)
    {
        /** @var \App\User $user */
        $user = $request->user();
        $user->saveSettings($request->only(['editor', 'default_nested', 'advanced_mentions', 'new_entity_workflow', 'campaign_switcher_order_by']))
            ->update($request->only(['theme', 'default_pagination', 'date_format']));

        //refresh user campaigns in cache if order by has changed
        if ($request->has('campaign_switcher_order_by')) {
            \App\Facades\UserCache::clearCampaigns();
            \App\Facades\UserCache::clearFollows();
        }

        return redirect()
            ->route('settings.appearance')
            ->with('success', __('settings.layout.success'));
    }
}
