<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\AchievementService;

/**
 * Class StatController
 * @package App\Http\Controllers\Campaign
 */
class AchievementController extends Controller
{
    protected AchievementService $service;

    public function __construct(AchievementService $service)
    {
        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $achievements = $this->service->campaign($campaign)->stats();

        return view('campaigns.achievements.index', compact('campaign', 'achievements'));
    }
}
