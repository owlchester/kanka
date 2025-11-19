<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Dashboards\GettingStartedService;

class GettingStartedController extends Controller
{
    public function __construct(protected GettingStartedService $gettingStartedService) {}

    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return response()->json($this->gettingStartedService->campaign($campaign)->tasks());
    }
}
