<?php

namespace App\Http\Controllers\Campaign;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRoleUser;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Services\Campaign\MemberService;

class RoleUserController extends Controller
{
    protected string $view = 'campaigns.roles.users';

    protected MemberService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MemberService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        return redirect()->route('campaign_roles.index', $campaign);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('roles', $campaign);
        $this->authorize('user', $campaignRole);

        return view($this->view . '.create', ['campaign' => $campaign, 'role' => $campaignRole]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaignRoleUser $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('roles', $campaign);
        $this->authorize('create', CampaignRole::class);

        $relation = CampaignRoleUser::create($request->all());
        return redirect()->route('campaign_roles.show', [
            $campaign,
            'campaign_role' => $campaignRole])
            ->with('success', __($this->view . '.create.success', [
                'user' => $relation->user->name,
                'role' => $relation->campaignRole->name
            ]));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Campaign $campaign, CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        return redirect()
            ->route('campaign_roles.show', [$campaign, $campaignRole]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignRole $campaignRole, CampaignRoleUser $campaignRoleUser)
    {
        $this->authorize('roles', $campaign);
        $this->authorize('view', [$campaignRoleUser, $campaign]);
        $this->authorize('delete', [$campaignRoleUser, $campaignRole]);

        try {
            $this->service
                ->user(auth()->user())
                ->element($campaignRoleUser)
                ->delete();
        } catch (TranslatableException $e) {
            return redirect()->route('campaign_roles.show', [$campaign, $campaignRole])
                ->with('error_raw', $e->getTranslatedMessage());
        }

        return redirect()->route('campaign_roles.show', [$campaign, $campaignRole])
            ->with('success', __($this->view . '.destroy.success', [
                'user' => $campaignRoleUser->user->name,
                'role' => $campaignRoleUser->campaignRole->name
            ]));
    }
}
