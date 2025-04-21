<?php

namespace App\Http\Controllers\Campaign\Members;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRoles;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Services\Campaign\MemberService;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected MemberService $memberService
    ) {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('members', $campaign);

        $roles = $campaign->roles->where('is_public', false)->all();

        return view('campaigns.members.update', [
            'campaign' => $campaign,
            'roles' => $roles,
            'campaignUser' => $campaignUser,
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(UpdateUserRoles $request, Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('update', $campaignUser);
        if (request()->ajax()) {
            return response()->json();
        }
        try {
            $this->memberService
                ->campaign($campaign)
                ->update($campaignUser, $request->get('roles', []));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('campaign_users.index', $campaign)
                ->with('error_raw', $e->getTranslatedMessage());
        }

        return redirect()
            ->route('campaign_users.index', $campaign)
            ->with('success', __('campaigns/members.roles.success', [
                'user' => $campaignUser->user->name,
            ]));
    }
}
