<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use CampaignAware;
    use HasDatagrid;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('members', $campaign);

        $this->rows = $campaign
            ->members()
            ->sort(request()->only(['o', 'k']), ['id' => 'desc'])
            ->with([
                'user:id,name,avatar,last_login_at,has_last_login_sharing,banned_until',
                'user.campaignRoles',
            ])
            ->paginate();

        $invitations = $campaign
            ->invites()
            ->where('is_active', true)
            ->with('role')
            ->paginate();

        $roles = $campaign->roles->where('is_public', false)->all();

        Datagrid::campaign($campaign)->layout(\App\Renderers\Layouts\Campaign\CampaignUser::class);
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return view('campaigns.members.index', [
            'campaign' => $campaign,
            'roles' => $roles,
            'invitations' => $invitations,
            'rows' => $this->rows,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('invite', $campaign);
        $this->authorize('view', [$campaignUser, $campaign]);

        $campaignUser->delete();

        return redirect()->route('campaign_users.index', $campaign);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
                'text' => $member->name,
            ];
        }

        return response()->json($results);
    }
}
