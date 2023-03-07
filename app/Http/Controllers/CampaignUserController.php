<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignUser;

class CampaignUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('members', $campaign);

        $users = $campaign
            ->members()
            ->with(['user', 'campaign', 'user.campaignRoles', 'user.campaignRoleUser'])
            ->paginate();

        $invitations = $campaign
            ->unusedInvites()
            ->with('role')
            ->paginate();

        $roles = $campaign->roles->where('is_public', false)->all();
        return view('campaigns.users', [
            'campaign' => $campaign,
            'roles' => $roles,
            'users' => $users,
            'invitations' => $invitations
        ]);
    }

    /**
     * @param CampaignUser $campaignUser
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('delete', $campaignUser);

        $campaignUser->delete();
        return redirect()->route('campaign_users.index', $campaign);
    }
}
