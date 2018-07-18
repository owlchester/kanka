<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreUserDashboardSetting;
use Illuminate\Support\Facades\Auth;

use App\Campaign;
use App\Models\Character;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Check the campaign
        $campaign = CampaignLocalization::getCampaign();
        if (empty($campaign) || (Auth::check() && !Auth::user()->hasCampaigns())) {
            return redirect()->route('start');
        }

        $recentCount = 5;
        $user = null;
        $settings = null;
        if (Auth::check()) {
            $user = Auth::user();
            $settings = $user->dashboardSetting;
            $recentCount = $user->dashboardSetting->recent_count;
        }

        $notes = Note::acl($user)->dashboard()->get();
        $characters = Character::acl($user)->recent()->with('family')->take($recentCount)->get();
        $families = Family::acl($user)->recent()->take($recentCount)->get();
        $locations = Location::acl($user)->recent()->take($recentCount)->get();
        $items = Item::acl($user)->recent()->take($recentCount)->get();
        $organisations = Organisation::acl($user)->recent()->take($recentCount)->get();
        $journals = Journal::acl($user)->recent()->take($recentCount)->get();

        //$characters = Character::

        $release = Release::with(['category'])
            ->where('status', 'PUBLISHED')
            ->orderBy('created_at', 'DESC')
            ->first();

        return view('home', compact(
            'campaign',
            'notes',
            'characters',
            'families',
            'locations',
            'items',
            'journals',
            'organisations',
            'settings',
            'release'
        ));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('dashboard.settings.setting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Family $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserDashboardSetting $request)
    {
        $setting = Auth::user()->dashboardSetting;
        $setting->update($request->all());
        return redirect()->route('home')->with('success', trans('dashboard.settings.edit.success'));
    }
}
