<?php

namespace App\Http\Controllers;

use App\Facades\CampaignCache;
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
    protected string $view = 'campaigns.roles.users';

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
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(CampaignRole $campaignRole)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);
        $this->authorize('user', $campaignRole);

        return view($this->view . '.create', ['campaign' => $campaign, 'role' => $campaignRole]);
    }

    /**
     * @param StoreCampaignRoleUser $request
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param CampaignRole $campaignRole
     * @param CampaignRoleUser $campaignRoleUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        return redirect()
            ->route('campaign_roles.show', $campaignRole);
    }

    /**
     * @param CampaignRole $campaignRole
     * @param CampaignRoleUser $campaignRoleUser
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);
        $this->authorize('delete', [$campaignRoleUser, $campaignRole]);

        $campaignRoleUser->delete();
        return redirect()->route('campaign_roles.show', $campaignRole)
            ->with('success', __($this->view . '.destroy.success', [
                'user' => $campaignRoleUser->user->name,
                'role' => $campaignRoleUser->campaignRole->name
            ]));
    }
}
