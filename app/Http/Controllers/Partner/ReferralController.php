<?php


namespace App\Http\Controllers\Partner;


use App\Models\Referral;

class ReferralController
{
    public function index()
    {
        $referrals = Referral::where('user_id', auth()->user()->id)->get();

        return view('partners.referrals.index', compact(
            'referrals'
        ));
    }
}
