<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Models\CampaignRole;
use App\Http\Requests\StoreCampaignRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignRoleController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'campaigns.roles';

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
    public function create(Campaign $campaign)
    {
        $this->authorize('create', CampaignRole::class);
        return view($this->view . '.create', ['model' => $campaign]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRole $request, Campaign $campaign)
    {
        $this->authorize('create', CampaignRole::class);
        $relation = CampaignRole::create($request->all());
        return redirect()->route('campaigns.show', [$campaign->id, '#roles'])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('view', $campaignRole);

        return view($this->view . '.show', [
            'model' => $campaign,
            'role' => $campaignRole
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);

        return view($this->view . '.edit', [
            'model' => $campaign,
            'role' => $campaignRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignRole $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);

        $campaignRole->update($request->all());
        return redirect()->route('campaigns.show', [$campaign->id, '#roles'])
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('delete', $campaignRole);

        $campaignRole->delete();
        return redirect()->route('campaigns.show', [$campaignRole->campaign_id, '#roles'])
            ->with('success', trans($this->view . '.destroy.success'));
    }

    public function savePermissions(Request $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);

        $campaignRole->savePermissions($request->post('permissions'));

        return redirect()->route('campaigns.campaign_roles.show', ['campaign' => $campaign, 'campaign_role' => $campaignRole])
            ->with('success', trans('crud.permissions.success'));
    }
}
