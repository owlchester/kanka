<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\LeaveService;
use Exception;

class LeaveController extends Controller
{
    protected LeaveService $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('leave', $campaign);

        try {
            $this->leaveService
                ->campaign($campaign)
                ->user(auth()->user())
                ->leave();
            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect()->route('overview', $campaign)->withErrors($e->getMessage());
        }
    }
}
