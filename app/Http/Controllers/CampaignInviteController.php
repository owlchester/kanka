<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests\StoreCampaignInvite;
use App\Models\CampaignInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('invite', $campaign);
        $ajax = request()->ajax();

        $type = request()->get('type', 'email');
        if (!in_array($type, ['email', 'link'])) {
            $type = 'email';
        }

        return view('campaigns.invites.create', compact('campaign', 'ajax', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignInvite $request, Campaign $campaign)
    {
        $this->authorize('invite', $campaign);

        $invitation = CampaignInvite::create($request->only('email', 'role_id', 'type', 'validity'));

        return redirect()->route('campaigns.index', ['#member'])
            ->with('success_raw',
                trans(
                    'campaigns.invites.create.' . ($invitation->type == 'email' ? 'success' : 'link'),
                    ['url' => route('campaigns.join', $invitation->token)]
                )
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CampaignUser  $campaignUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign, CampaignInvite $campaignInvite)
    {
        $this->authorize('delete', $campaignInvite);

        $campaignInvite->delete();
        return redirect()->route('campaigns.index', ['#member'])
            ->with('success', trans('campaigns.invites.destroy.success'));
    }
}
