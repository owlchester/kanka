<?php

namespace App\Services;

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralService
{
    /** @var string Referral GET parameter */
    protected $key = 'ref';

    /**
     * Validate a referral and save it to the session
     */
    public function validate(Request $request): void
    {
        if (! $request->has($this->key)) {
            return;
        }

        $code = $request->get($this->key);
        $referral = Referral::where('code', $code)->where('is_valid', true)->first();
        if (! $referral) {
            return;
        }

        // A valid referral, save it to the session
        session()->put('referral_id', $referral->id);
    }

    public function referralId()
    {
        if (! session()->has('referral_id')) {
            return null;
        }

        $referral = session()->get('referral_id', null);
        session()->forget('referral_id');

        return $referral;
    }
}
