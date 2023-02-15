<?php

namespace App\Http\Controllers\Campaign;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignUser;
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
