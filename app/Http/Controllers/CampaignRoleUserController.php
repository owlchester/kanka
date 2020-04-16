<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Http\Requests\StoreCampaignRoleUser;
use App\Models\CampaignRoleUser;

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
    public function create(CampaignRole $campaignRole)
    {
        $this->authorize('user', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

        return view($this->view . '.create', ['campaign' => $campaign, 'role' => $campaignRole]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRoleUser $request, CampaignRole $campaignRole)
    {
        $this->authorize('create', CampaignRole::class);
        $campaign = $campaignRole->campaign;
        $relation = CampaignRoleUser::create($request->all());
        return redirect()->route('campaign_roles.show', [
            'campaign_role' => $campaignRole])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('user', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

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
    public function edit(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('user', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

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
    public function update(
        StoreCampaignRoleUser $request,
        CampaignRole $campaignRole,
        CampaignRoleUser $campaignRoleUser
    ) {
        $this->authorize('user', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

        $campaignRoleUser->update($request->all());
        return redirect()->route('campaign_roles.show', $campaignRole)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('removeUser', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

        $campaignRoleUser->delete();
        return redirect()->route('campaign_roles.show', $campaignRole)
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
