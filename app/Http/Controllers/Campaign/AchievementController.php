<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\AchievementService;

/**
 * Class StatController
 */
class AchievementController extends Controller
{

    public function __construct(protected AchievementService $service)
    {
    }

    public function index(Campaign $campaign)
    {
        $achievements = $this->service->campaign($campaign)->stats();

        return view('campaigns.achievements.index', compact('campaign', 'achievements'));
    }
}
