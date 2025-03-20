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

    public function index(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        $submission = auth()->user()->submissions()->first();

        return view('campaigns.submissions.apply')
            ->with('submission', $submission)
            ->with('campaign', $campaign);
    }

    public function save(StoreCampaignApplication $request, Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var ?CampaignSubmission $submission */
        $submission = auth()->user()->submissions()->first();
        if (! empty($submission)) {
            $submission->update(['text' => $request->get('application')]);
            $success = __('campaigns/submissions.apply.success.update');
        } else {
            $this->service
                ->user(auth()->user())
                ->campaign($campaign)
                ->apply($request->get('application'));

            $success = __('campaigns/submissions.apply.success.apply');
        }

        return redirect()
            ->route('dashboard', $campaign)
            ->with('success', $success);
    }

    public function remove(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var ?CampaignSubmission $submission */
        $submission = auth()->user()->submissions()->first();
        if (! empty($submission)) {
            $submission->delete();
        }

        return redirect()
            ->route('dashboard', $campaign)
            ->with('success', __('campaigns/submissions.apply.success.remove'));
    }
}
