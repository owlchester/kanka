<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\Referrals\ManagementService;

class ReferralController extends Controller
{
    public function __construct(protected ManagementService $service) {}

    public function index()
    {
        $this->service->user(auth()->user());

        return view('settings.referrals.index')
            ->with('referral', $this->service->referral())
            ->with('users', $this->service->users())
            ->with('subscribers', $this->service->subscribers())
            ->with('badge', $this->service->badge());
    }
}
