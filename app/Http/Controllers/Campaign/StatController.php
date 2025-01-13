<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\StatService;

class StatController extends Controller
{
    protected StatService $service;

    public function __construct(StatService $statService)
    {
        $this->service = $statService;
    }
    public function index(Campaign $campaign)
    {
        $stats = $this->service->campaign($campaign)->get();
        return view('campaigns.stats.index')
            ->with('campaign', $campaign)
            ->with('stats', $stats);
    }
}
