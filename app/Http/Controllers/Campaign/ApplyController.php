<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreCampaignApplication;
use App\Models\Application;
use App\Models\Campaign;
use App\Services\Campaign\ApplicationService;

class ApplyController extends Controller
{
    protected ApplicationService $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        $application = auth()->user()->applications()->first();

        return view('campaigns.applications.apply')
            ->with('application', $application)
            ->with('campaign', $campaign);
    }

    public function save(StoreCampaignApplication $request, Campaign $campaign)
    {
        $this->authorize('apply', $campaign);

        /** @var ?Application $application */
        $application = auth()->user()->applications()->first();
        if (! empty($application)) {
            $application->update(['text' => $request->get('application')]);
            $success = __('campaigns/applications.apply.success.update');
        } else {
            $this->service
                ->user(auth()->user())
                ->campaign($campaign)
                ->apply($request->get('application'));

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
