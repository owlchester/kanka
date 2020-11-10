<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Services\Campaign\StatService;

/**
 * Class StatController
 * @package App\Http\Controllers\Campaign
 */
class StatController extends Controller
{
    /** @var StatService */
    protected $service;

    public function __construct(StatService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $service;
    }

    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('stats', $campaign);

        $stats = $this->service->campaign($campaign)->stats();

        return view('campaigns.stats.index', compact('campaign', 'stats'));
    }
}
