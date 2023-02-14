<?php

namespace App\Http\Controllers\Campaign;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\Services\Campaign\MemberService;
use Illuminate\Http\Request;

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
     */
    public function switch(CampaignUser $campaignUser, Entity $entity = null)
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
     * UI for updating a user of the campaign's role
     */
    public function updateRoles(Campaign $campaign, CampaignUser $campaignUser, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignUser);

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

    /**
     * Endpoint for searching members of the campaign based by name
     */
    public function search(Request $request, Campaign $campaign)
    {
        $this->authorize('members', $campaign);

        $term = $request->get('q', null);
        if (empty($term)) {
            $members = $campaign->users()->orderBy('name', 'asc')->limit(5)->get();
        } else {
            $members = $campaign->users()->where('name', 'like', '%' . $term . '%')->limit(5)->get();
        }

        $results = [];
        foreach ($members as $member) {
            $results[] = [
                'id' => $member->id,
                'text' => $member->name
            ];
        }

        return response()->json($results);
    }
}
