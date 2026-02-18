<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\ApplicationStatus;
use App\Enums\CampaignFilterType;
use App\Enums\CampaignFlags;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\PatchCampaignApplication;
use App\Http\Requests\Campaigns\StoreCampaignApplicationStatus;
use App\Http\Requests\Campaigns\StoreCampaignSetup;
use App\Models\Application;
use App\Models\Campaign;
use App\Models\CampaignFilter;
use App\Services\Campaign\ApplicationService;
use DateTimeZone;

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

        $campaign->update([
            'is_open' => $request->get('status'),
        ]);

        return redirect()
            ->route('applications.index', $campaign)
            ->with('success', __('campaigns/applications.toggle.success'));
    }

    public function setup(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        $identifiers = DateTimeZone::listIdentifiers();
        $timezones = [];

        for ($i = -12; $i <= 14; $i++) {
            $prefix = ($i >= 0) ? '+' : '-';
            // Formats to "UTC +05:00" or "UTC -11:00"
            $utcString = 'UTC ' . $prefix . str_pad(abs($i), 2, '0', STR_PAD_LEFT) . ':00';

            $timezones[$utcString] = $utcString;
        }

        return view('campaigns.applications.setup')
            ->with('campaign', $campaign)
            ->with('timezones', $timezones);
    }

    public function saveSetup(StoreCampaignSetup $request, Campaign $campaign)
    {
        $this->authorize('applications', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $campaign->update([
            'locale' => $request->get('locale'),
            'system' => $request->get('systems'),
            'genres' => $request->get('genres'),
        ]);

        if ($request->has('playstyles')) {
            $campaign->playstyles()->sync($request->input('playstyles'));
        }

        // Map request keys to Enum types
        $filters = [
            'intro' => CampaignFilterType::Intro,
            'timezone' => CampaignFilterType::Timezone,
            'schedule' => CampaignFilterType::Schedule,
            'players' => CampaignFilterType::PlayerCount,
        ];

        foreach ($filters as $inputKey => $enumType) {
            // Only save if the user actually sent data for this field
            if ($request->filled($inputKey)) {
                CampaignFilter::updateOrCreate(
                    [
                        'campaign_id' => $campaign->id,
                        'type' => $enumType,
                    ],
                    [
                        'entry' => $request->input($inputKey),
                    ]
                );
            }
        }

        // Define the fields required to "Open" the campaign
        $requiredFields = ['intro', 'timezone', 'schedule', 'players', 'locale', 'systems', 'genres', 'playstyles'];

        // Check if all required fields have a value in the request
        $allFilled = collect($requiredFields)->every(fn ($field) => $request->filled($field));
        if ($allFilled) {

            // updateOrCreate prevents duplicate flags if the user updates the campaign
            $campaign->flags()->updateOrCreate([
                'flag' => CampaignFlags::CanOpen->value,
            ]);
        } else {
            // Optional: Remove the flag if the user clears a field later
            $campaign->flags()->where('flag', CampaignFlags::CanOpen->value)->delete();
        }

        return redirect()
            ->route('applications.index', $campaign)
            ->with('success', __('campaigns/applications.setup.success'));
    }
}
