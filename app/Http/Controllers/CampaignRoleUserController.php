<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Models\CampaignRole;
use App\Http\Requests\StoreCampaignRoleUser;
use App\Models\CampaignRoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignRoleUserController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'campaigns.roles.users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('user', $campaignRole);
        return view($this->view . '.create', ['campaign' => $campaign, 'role' => $campaignRole]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRoleUser $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('create', CampaignRole::class);
        $relation = CampaignRoleUser::create($request->all());
        return redirect()->route('campaigns.campaign_roles.show', [
            'campaign' => $campaign, 'campaign_role' => $campaignRole])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign, CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('user', $campaignRole);

        return view($this->view . '.show', [
            'campaign' => $campaign,
            'role' => $campaignRole,
            'user' =>  $campaignRoleUser
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('user', $campaignRole);

        return view($this->view . '.edit', [
            'campaign' => $campaign,
            'role' => $campaignRole,
            'user' => $campaignRoleUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignRoleUser $request, Campaign $campaign, CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('user', $campaignRole);

        $campaignRoleUser->update($request->all());
        return redirect()->route('campaigns.campaign_roles.show', [
            'campaign' => $campaign, 'campaignRole' => $campaignRole])
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign, CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('user', $campaignRole);

        $campaignRoleUser->delete();
        return redirect()->route('campaigns.campaign_roles.show', [
            'campaign' => $campaign, 'campaignRole' => $campaignRole])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
