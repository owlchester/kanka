<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;
use App\Http\Requests\StoreCampaignRole;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        return view('campaigns.roles', ['campaign' => $campaign]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', CampaignRole::class);
        $campaign = CampaignLocalization::getCampaign();
        $ajax = request()->ajax();

        return view($this->view . '.create', ['model' => $campaign, 'ajax' => $ajax]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRole $request)
    {
        $this->authorize('create', CampaignRole::class);
        $relation = CampaignRole::create($request->all());
        return redirect()->route('campaign_roles.index')
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignRole $campaignRole)
    {
        $this->authorize('view', $campaignRole);

        $campaign = CampaignLocalization::getCampaign();
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
    public function edit(CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();
        $ajax = request()->ajax();

        return view($this->view . '.edit', [
            'model' => $campaign,
            'role' => $campaignRole,
            'ajax' => $ajax
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignRole $request, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

        $campaignRole->update($request->all());
        return redirect()->route('campaign_roles.index')
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignRole $campaignRole)
    {
        $this->authorize('delete', $campaignRole);

        $campaignRole->delete();
        return redirect()->route('campaign_roles.index')
            ->with('success', trans($this->view . '.destroy.success'));
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function savePermissions(Request $request, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);

        $campaignRole->savePermissions($request->post('permissions'));

        return redirect()->route('campaign_roles.show', ['campaign_role' => $campaignRole])
            ->with('success', trans('crud.permissions.success'));
    }
}
