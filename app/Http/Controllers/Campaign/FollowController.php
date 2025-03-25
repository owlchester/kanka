<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\FollowService;

class FollowController extends Controller
{
    protected FollowService $service;

    public function __construct(FollowService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function update(Campaign $campaign)
    {
        $this->authorize('follow', $campaign);

        return response()->json([
            'following' => $this->service
                ->campaign($campaign)
                ->user(auth()->user())
                ->update(),
        ]);
    }
}
