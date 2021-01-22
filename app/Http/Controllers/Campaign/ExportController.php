<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\EntityService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * @var CampaignService
     */
    protected $campaignService;

    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CampaignService $campaignService, EntityService $entityService)
    {
        $this->middleware('auth');
        $this->campaignService = $campaignService;
        $this->entityService = $entityService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        return view('campaigns.export', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('setting', $campaign);

        try {
            $this->campaignService
                ->export($campaign, auth()->user(), $this->entityService);

            return redirect()->route('campaign_export')
                ->with('success', trans('campaigns.export.success'));
        } catch (\Exception $e) {
            return redirect()->route('campaign_export')->withErrors($e->getMessage());
        }
    }
}
