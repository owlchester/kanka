<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignUser;
use App\Family;
use App\FamilyRelation;
use App\Http\Requests\StoreCampaign;
use App\Http\Requests\StoreCampaignUser;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreFamilyRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.owner');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaign = Campaign::findOrFail(Session::get('campaign_id'));
        return view('campaigns.users.create', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignUser $request)
    {
        $relation = CampaignUser::create($request->all());
        return redirect()->route('campaigns.show', [$relation->campaign_id, 'tab' => 'relation'])->with('success', 'Campaign user added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CampaignUser  $campaignUser
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignUser $campaignUser)
    {
        return view('campaigns.users.edit', compact('campaignUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CampaignUser  $campaignUser
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignUser $request, CampaignUser $campaignUser)
    {
        $campaignUser->update($request->all());
        return redirect()->route('campaigns.show', $campaignUser->campaign_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CampaignUser  $campaignUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignUser $campaignUser)
    {
        $campaignUser->delete();
        return redirect()->route('campaigns.show', [$campaignUser->campaign_id, 'tab' => 'relation']);
    }
}
