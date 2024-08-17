<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Gallery\SetupService;

class SetupController extends Controller
{
    protected SetupService $service;

    public function __construct(SetupService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        return response()->json(
            $this->service
                ->user(auth()->user())
                ->campaign($campaign)
                ->setup()
        );
    }
}
