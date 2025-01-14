<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Campaign\StatService;

class StatController extends Controller
{
    public function __construct(
        protected StatService $statService
    )
    {
    }

    public function index(Campaign $campaign)
    {
        $stats = $this->statService->campaign($campaign)->get();

        $entityTypes = [];
        /** @var EntityType $entityType */
        foreach (EntityType::inCampaign($campaign)->get() as $entityType) {
            $entityTypes[$entityType->id] = $entityType;
        }
        return view('campaigns.stats.index')
            ->with('campaign', $campaign)
            ->with('stats', $stats)
            ->with('entityTypes', $entityTypes)
            ;
    }
}
