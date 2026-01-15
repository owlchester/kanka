<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Services\Referrals\JoinService;

class ReferralController extends Controller
{
    public function __construct(protected JoinService $service) {}

    public function index(Referral $referral)
    {
        if (auth()->guest()) {
            if ($this->service->referral($referral)->expired()) {
                abort(404);
            }
            $this->service->flag();

            return redirect()->route('register');
        }

        // Already logged in? Just redirect to their dashboard
        return redirect()->route('home');
    }
}
