<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\Connections\WebService;

class WebController extends Controller
{
    public function __construct(protected WebService $webService) {}

    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return view('connections.web')
            ->with('campaign', $campaign);
    }

    public function api(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        if (auth()->check()) {
            $this->webService->user(auth()->user());
        }

        return response()->json(
            $this->webService->campaign($campaign)->build()
        );
    }
}
