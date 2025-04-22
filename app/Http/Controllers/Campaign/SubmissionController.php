<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\PatchCampaignApplication;
use App\Http\Requests\Campaigns\StoreCampaignApplicationStatus;
use App\Models\Campaign;
use App\Models\CampaignSubmission;
use App\Services\Campaign\ApplicationService;

class SubmissionController extends Controller
{
    public function __construct(protected ApplicationService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('submissions', $campaign);

        $submissions = $campaign->submissions()->with('user')->paginate();

        return view('campaigns.submissions.index')
            ->with('submissions', $submissions)
            ->with('campaign', $campaign);
    }

    public function show(Campaign $campaign, CampaignSubmission $campaignSubmission)
    {
        $this->authorize('submissions', $campaign);

        if (! $campaign->canHaveMoreMembers()) {
            return view('cruds.forms.limit')
                ->with('campaign', $campaign)
                ->with('key', 'members')
                ->with('name', 'campaign_roles');
        }

        return view('campaigns.submissions.show')
            ->with('application', $campaignSubmission)
            ->with('campaign', $campaign);
    }

    public function edit(Campaign $campaign, CampaignSubmission $campaignSubmission)
    {
        $this->authorize('submissions', $campaign);

        if (! $campaign->canHaveMoreMembers()) {
            return view('cruds.forms.limit')
                ->with('campaign', $campaign)
                ->with('key', 'members')
                ->with('name', 'campaign_roles');
        }

        $action = request()->get('action');
        if (! in_array($action, ['approve', 'reject'])) {
            return redirect()->route('campaign_submissions.index', $campaign);
        }

        return view('campaigns.submissions.edit')
            ->with('submission', $campaignSubmission)
            ->with('campaign', $campaign)
            ->with('action', $action);
    }

    public function update(PatchCampaignApplication $request, Campaign $campaign, CampaignSubmission $campaignSubmission)
    {
        $this->authorize('submissions', $campaign);

        if (! $campaign->canHaveMoreMembers()) {
            return redirect()->back()
                ->with('error', __('Campaign is full, please boost it.'));
        }

        if ($request->ajax()) {
            return response()->json();
        }

        $note = $this->service
            ->user(auth()->user())
            ->campaign($campaign)
            ->submission($campaignSubmission)
            ->process($request->only('role_id', 'rejection', 'action', 'reason'));

        return redirect()->route('campaign_submissions.index', $campaign)
            ->with('success', __('campaigns/submissions.update.' . $note));
    }

    public function toggle(Campaign $campaign)
    {
        $this->authorize('submissions', $campaign);

        return view('campaigns.submissions._toggle', compact('campaign'));
    }

    public function toggleSave(StoreCampaignApplicationStatus $request, Campaign $campaign)
    {
        $this->authorize('submissions', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $campaign->update([
            'is_open' => $request->get('status'),
        ]);
        auth()->user()->campaignLog(
            $campaign->id,
            'applications',
            'switch',
            ['new' => $campaign->isOpen() ? 'open' : 'closed']
        );

        return redirect()
            ->route('campaign_submissions.index', $campaign)
            ->with('success', __('campaigns/submissions.toggle.success'));
    }
}
