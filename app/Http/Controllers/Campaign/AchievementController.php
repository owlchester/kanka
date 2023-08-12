<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\StatService;

/**
 * Class StatController
 * @package App\Http\Controllers\Campaign
 */
class AchievementController extends Controller
{
    protected StatService $service;

    public function __construct(StatService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('stats', $campaign);

        $stats = $this->service->campaign($campaign)->stats();

        return view('campaigns.stats.index', compact('campaign', 'stats'));
    }
}
