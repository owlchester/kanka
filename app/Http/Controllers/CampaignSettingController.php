<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        $campaign->setting->update($request->all());

        return redirect()->route('campaigns.index', ['#setting'])
            ->with('success', trans('campaigns.settings.edit.success'));
    }
}
