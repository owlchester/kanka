<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreCampaignInvite;
use App\Models\Campaign;
use App\Models\CampaignInvite;

class CampaignInviteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Create a new invitation link form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('invite', $campaign);

        if (!$campaign->canHaveMoreMembers()) {
            return view('cruds.forms.limit')
                ->with('key', 'members')
                ->with('skipImage', true)
                ->with('name', 'campaign_roles');
        }

        $roles = $campaign->roles()->where('is_admin', 0)->where('is_public', 0)->orderBy('name')->pluck('name', 'id');

        return view('campaigns.invites.create', compact('campaign', 'roles'));
    }

    /**
     * Save the new invitation link to the database
     * @param StoreCampaignInvite $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaignInvite $request, Campaign $campaign)
    {
        $this->authorize('invite', $campaign);

        $data = $request->only('role_id', 'validity');
        $data['campaign_id'] = $campaign->id;
        /** @var CampaignInvite $invitation */
        $invitation = CampaignInvite::create($data);

        $link = route('campaigns.join', $invitation->token);
        $copy = link_to('#', '<i class="fa-solid fa-copy"></i> ' . __('campaigns.invites.actions.copy'), [
            'data-clipboard' => $link,
            'data-toggle' => 'tooltip',
            'data-toast' => __('crud.alerts.copy_invite'),
            'title' => __('campaigns.invites.actions.copy')
        ], null, false);

        return redirect()->route('campaign_users.index', $campaign)
            ->with(
                'success_raw',
                __(
                    'campaigns.invites.create.success_link',
                    ['link' => $copy]
                )
            );
    }

    /**
     * Remove an invitation link
     * @param CampaignInvite $campaignInvite
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignInvite $campaignInvite)
    {
        $this->authorize('invite', $campaign);

        $campaignInvite->delete();
        return redirect()->route('campaign_users.index', $campaign)
            ->with('success', __('campaigns.invites.destroy.success'));
    }
}
