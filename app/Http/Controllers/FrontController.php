<?php

namespace App\Http\Controllers;

use App\Facades\FrontCache;
use App\Http\Requests\FilterPublicCampaignRequest;
use App\Models\Campaign;
use App\Services\ReferralService;
use Carbon\Carbon;

class FrontController extends Controller
{
    /**
     * FrontController constructor.
     */
    public function __construct(ReferralService $referralService)
    {
        $referralService->validate(request());

        $this->middleware('fullsetup', ['except' => 'index']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Don't want unlogged people to think about this url
        if (!auth()->check()) {
            return redirect()->route('home');
        }
        $campaigns = FrontCache::featured();
        return view('front.home')
            ->with('campaigns', $campaigns);
    }
}
