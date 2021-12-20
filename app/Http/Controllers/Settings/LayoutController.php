<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsLayout;
use Illuminate\Support\Facades\Auth;

class LayoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.layout');
    }

    /**
     * @param StoreSettingsLayout $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreSettingsLayout $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();
        $user->saveSettings($request->only(['editor', 'default_nested', 'advanced_mentions', 'new_entity_workflow', 'campaign_switcher_order_by']))
            ->update($request->only(['theme', 'default_pagination', 'date_format']));

        //refresh user campaigns in cache if order by has changed
        if ($request->has('campaign_switcher_order_by')) {
            \App\Facades\UserCache::clearCampaigns();
            \App\Facades\UserCache::clearFollows();
        }

        return redirect()
            ->route('settings.layout')
            ->with('success', __('settings.layout.success'));
    }
}
