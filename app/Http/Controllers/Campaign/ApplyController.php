<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreCampaignApplication;
use App\Models\Campaign;
use App\Models\CampaignSubmission;
use App\Services\Campaign\SubmissionService;

class ApplyController extends Controller
{
    protected SubmissionService $service;

    public function __construct(SubmissionService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        $submission = auth()->user()->submissions()->first();

        return view('campaigns.submissions.apply')
            ->with('submission', $submission)
            ->with('campaign', $campaign)
            ->with('ajax', request()->ajax())
        ;
    }

    /**
     * @param StoreCampaignApplication $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(StoreCampaignApplication $request, Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var CampaignSubmission|null $submission */
        $submission = auth()->user()->submissions()->first();
        if (!empty($submission)) {
            $submission->update(['text' => $request->get('application')]);
            $success = __('campaigns/submissions.apply.success.update');
        } else {
            $submission = new CampaignSubmission();
            $submission->text = $request->get('application');
            $submission->user_id = auth()->user()->id;
            $submission->campaign_id = $campaign->id;
            $submission->save();
            $success = __('campaigns/submissions.apply.success.apply');

            $this->service
                ->campaign($campaign)
                ->notifyAdmins();
        }

        return redirect()->route('dashboard')
            ->with('success', $success);
    }

    public function remove(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var CampaignSubmission|null $submission */
        $submission = auth()->user()->submissions()->first();
        if (!empty($submission)) {
            $submission->delete();
        }
        return redirect()->route('dashboard')
            ->with('success', __('campaigns/submissions.apply.success.remove'));
    }
}
