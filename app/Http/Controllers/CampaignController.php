<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignUser;
use App\Http\Requests\StoreCampaign;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.owner', ['only' => ['edit', 'destroy', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('campaign_id')) {
            $campaign = Campaign::whereHas('users', function ($q) { $q->where('users.id', Auth::user()->id); })->where('id', $request->get('campaign_id'))->firstOrFail();
            CampaignService::switchCampaign($campaign->id);
            return redirect()->to('/home');
        }

        $active = Session::get('campaign_id');
        $campaigns = null;
        $campaign = null;
        if (!empty($active)) {
            $campaigns = Campaign::whereHas('users', function ($q) { $q->where('users.id', Auth::user()->id); })->where('id', '!=', $active)->get();
            $campaign = Campaign::where('id', $active)->first();
        } else {
            $campaigns = Campaign::whereHas('users', function ($q) { $q->where('users.id', Auth::user()->id); })->get();
        }

        if (!empty($campaign) && empty($campaign->join_token)) {
            $campaign->newToken();
        }

        return view('campaigns.index', compact('campaigns', 'campaign', 'active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaign $request)
    {
        Campaign::create($request->all());
        return redirect()->to('/home')->with('success', 'Campaign created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return view('campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaign $request, Campaign $campaign)
    {
        $campaign->update($request->all());
        return redirect()->route('campaigns.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
