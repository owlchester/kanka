<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\CampaignUser;
use App\Http\Requests\StoreCampaignUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignUserController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('members', $campaign);

        $users = $campaign
            ->members()
            ->with(['user', 'campaign', 'user.campaignRoles'])
            ->paginate();

        $invitations = $campaign
            ->unusedInvites()
            ->with('role')
            ->paginate();

        $roles = $campaign->roles->where('is_public', false)->all();
        return view('campaigns.users', ['campaign' => $campaign, 'roles' => $roles, 'users' => $users, 'invitations' => $invitations]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignUser $campaignUser)
    {
        $this->authorize('invite', $campaignUser->campaign);

        $campaignUser->delete();
        return redirect()->route('campaign_users.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
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
