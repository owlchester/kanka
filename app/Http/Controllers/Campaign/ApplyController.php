<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreCampaignApplication;
use App\Models\Application;
use App\Models\Campaign;
use App\Services\Campaign\ApplicationService;
use DateTimeZone;

class ApplyController extends Controller
{
    public function __construct(protected ApplicationService $service)
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        $application = auth()->user()->applications()->first();

        $identifiers = DateTimeZone::listIdentifiers();
        $timezones = [];

        for ($i = -12; $i <= 14; $i++) {
            $prefix = ($i >= 0) ? '+' : '-';
            // Formats to "UTC +05:00" or "UTC -11:00"
            $utcString = 'UTC ' . $prefix . str_pad(abs($i), 2, '0', STR_PAD_LEFT) . ':00';

            $timezones[$utcString] = $utcString;
        }

        return view('campaigns.applications.apply')
            ->with('application', $application)
            ->with('timezones', $timezones)
            ->with('campaign', $campaign);
    }

    public function save(StoreCampaignApplication $request, Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var ?Application $application */
        $application = auth()->user()->applications()->first();
        if (! empty($application)) {
            $application->update($request->all());
            $success = __('campaigns/applications.apply.success.update');
        } else {
            $this->service
                ->user(auth()->user())
                ->campaign($campaign)
                ->apply($request);

            $success = __('campaigns/applications.apply.success.apply');
        }

        return redirect()
            ->route('dashboard', $campaign)
            ->with('success', $success);
    }

    public function remove(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var ?Application $application */
        $application = auth()->user()->applications()->first();
        if (! empty($application)) {
            $application->delete();
        }

        return redirect()
            ->route('dashboard', $campaign)
            ->with('success', __('campaigns/applications.apply.success.remove'));
    }
}
