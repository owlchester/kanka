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

    public function index()
    {
        return redirect()->route('campaign_roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CampaignRole $campaignRole)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);
        $this->authorize('user', $campaignRole);

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
        $campaign = $campaignRole->campaign;
        $this->authorize('roles', $campaign);
        $this->authorize('create', CampaignRole::class);

        $relation = CampaignRoleUser::create($request->all());
        return redirect()->route('campaign_roles.show', [
            'campaign_role' => $campaignRole])
            ->with('success', __($this->view . '.create.success', [
                'user' => $relation->user->name,
                'role' => $relation->campaignRole->name
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        return redirect()
            ->route('campaign_roles.show', $campaignRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);
        $this->authorize('removeUser', $campaignRole);

        $campaignRoleUser->delete();
        return redirect()->route('campaign_roles.show', $campaignRole)
            ->with('success', __($this->view . '.destroy.success', [
                'user' => $campaignRoleUser->user->name,
                'role' => $campaignRoleUser->campaignRole->name
            ]));
    }
}
