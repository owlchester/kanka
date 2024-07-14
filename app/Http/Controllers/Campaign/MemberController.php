<?php

namespace App\Http\Controllers\Campaign;

use App\Exceptions\TranslatableException;
use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\Services\Campaign\MemberService;

class MemberController extends Controller
{
    protected MemberService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MemberService $memberService)
    {
        $this->middleware('auth');
        $this->service = $memberService;
    }

    /**
     * Switch to another member
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function switch(Campaign $campaign, CampaignUser $campaignUser, Entity $entity = null)
    {
        $this->authorize('switch', $campaignUser);

        if (Identity::campaign($campaign)->switch($campaignUser)) {
            if ($entity) {
                return redirect()
                    ->to($entity->url());
            }
            return redirect()
                ->route('dashboard', $campaign);
        }
        return redirect()
            ->route('dashboard', $campaign);
    }

    /**
     * Switch back to the original user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back(Campaign $campaign)
    {
        if (Identity::back()) {
            return redirect()
                ->route('dashboard', $campaign)
                ->with('success', __('campaigns.members.switch_back_success'));
        }
        return redirect()
            ->route('dashboard', $campaign);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateRoles(Campaign $campaign, CampaignUser $campaignUser, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignUser);
        if (request()->ajax()) {
            return response()->json();
        }

        try {
            $added = $this->service->update($campaignUser, $campaignRole);
        } catch (TranslatableException $e) {
            return redirect()
                ->route('campaign_users.index', $campaign)
                ->with('error_raw', $e->getTranslatedMessage());
        }

        return redirect()
            ->route('campaign_users.index', $campaign)
            ->with('success', __('campaigns.members.updates.' . ($added ? 'added' : 'removed'), [
                'user' => $campaignUser->user->name,
                'role' => $campaignRole->name
            ]));
    }

    public function delete(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('delete', $campaignUser);

        return view('campaigns.members.delete', $campaign)
            ->with('campaign', $campaign)
            ->with('campaignUser', $campaignUser);
    }
}
