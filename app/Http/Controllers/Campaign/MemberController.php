<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\CampaignRole;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\Services\Campaign\MemberService;
use Illuminate\Support\Facades\Request;

class MemberController extends Controller
{
    /** @var MemberService */
    protected $service;

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
     * Switch to a member of the campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switch(CampaignUser $campaignUser, Entity $entity)
    {
        $this->authorize('switch', $campaignUser);

        if (Identity::switch($campaignUser)) {
            if ($entity) {
                return redirect()
                    ->to($entity->url());
            }
            return redirect()
                ->route('dashboard');
        }
        return redirect()
            ->route('dashboard');
    }

    /**
     * Switch back to the original user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back()
    {
        if (Identity::back()) {
            return redirect()
                ->route('dashboard')
                ->with('success', __('campaigns.members.switch_back_success'));
        }
        return redirect()
            ->route('dashboard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRoles(CampaignUser $campaignUser, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignUser);

        $added = $this->service->update($campaignUser, $campaignRole);

        return redirect()
            ->route('campaign_users.index')
            ->with('success', __('campaigns.members.updates.' . ($added ? 'added' : 'removed'), [
                'user' => $campaignUser->user->name,
                'role' => $campaignRole->name
            ]));
    }
}
