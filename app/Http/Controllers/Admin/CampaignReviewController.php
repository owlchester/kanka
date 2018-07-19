<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;

class CampaignReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('moderator');
    }

    /**
     * List of campaigns awaiting review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaigns = Campaign::visibility(Campaign::VISIBILITY_REVIEW);
        return view('admin.campaigns.renew', compact('campaigns'));
    }
}
