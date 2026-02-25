<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\PatchCampaignApplication;
use App\Http\Requests\Campaigns\StoreCampaignApplicationStatus;
use App\Models\Application;
use App\Models\Campaign;
use App\Services\Campaign\ApplicationService;

class ApplicationController extends Controller
{
    public function __construct(protected ApplicationService $service)
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        if (request()->get('filter') && request()->get('filter') == 'approved') {
            $applications = $campaign->applications()->where('status', ApplicationStatus::Approved)->with('user')->paginate();
        } elseif (request()->get('filter') && request()->get('filter') == 'rejected') {
            $applications = $campaign->applications()->where('status', ApplicationStatus::Rejected)->with('user')->paginate();
        } elseif (request()->get('filter') && request()->get('filter') == 'all') {
            $applications = $campaign->applications()->with('user')->paginate();
        } else {
            $applications = $campaign->applications()->where('status', ApplicationStatus::Pending)->with('user')->paginate();
        }

        return view('campaigns.applications.index')
            ->with('applications', $applications)
            ->with('campaign', $campaign)
            ->with('filter', request()->get('filter'));
    }

    public function show(Campaign $campaign, Application $application)
    {
        $this->authorize('applications', $campaign);

        if (! $campaign->canHaveMoreMembers()) {
            return view('cruds.forms.limit')
                ->with('campaign', $campaign)
                ->with('key', 'members')
                ->with('name', 'campaign_roles');
        }

        if ($application->status == ApplicationStatus::Pending) {
            return view('campaigns.applications.show')
                ->with('application', $application)
                ->with('campaign', $campaign);
        }

        return view('campaigns.applications.view')
            ->with('application', $application)
            ->with('campaign', $campaign);
    }

    public function edit(Campaign $campaign, Application $application)
    {
        $this->authorize('applications', $campaign);

        if (! $campaign->canHaveMoreMembers()) {
            return view('cruds.forms.limit')
                ->with('campaign', $campaign)
                ->with('key', 'members')
                ->with('name', 'campaign_roles');
        }

        $action = request()->get('action');
        if (! in_array($action, ['approve', 'reject'])) {
            return redirect()->route('applications.index', $campaign);
        }

        return view('campaigns.applications.edit')
            ->with('application', $application)
            ->with('campaign', $campaign)
            ->with('action', $action);
    }

    public function update(PatchCampaignApplication $request, Campaign $campaign, Application $application)
    {
        $this->authorize('applications', $campaign);

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
            ->application($application)
            ->process($request->only('role_id', 'rejection', 'action', 'reason'));

        return redirect()->route('applications.index', $campaign)
            ->with('success', __('campaigns/applications.update.' . $note));
    }

    public function toggle(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        return view('campaigns.applications._toggle', compact('campaign'));
    }

    public function toggleSave(StoreCampaignApplicationStatus $request, Campaign $campaign)
    {
        $this->authorize('applications', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $isOpen = (bool) $request->get('status');

        $campaign->update([
            'is_open' => $isOpen,
        ]);

        $successKey = $isOpen ? 'campaigns/applications.toggle.success_open' : 'campaigns/applications.toggle.success';

        return redirect()
            ->route('applications.index', $campaign)
            ->with('success', __($successKey));
    }
}
