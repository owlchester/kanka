<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarketplaceProfile;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.marketplace');
    }

    /**
     * @param StoreMarketplaceProfile $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(StoreMarketplaceProfile $request)
    {
        Auth::user()
            ->saveSettings($request->only('marketplace_name'))
        ->update();

        return redirect()
            ->route('settings.marketplace')
            ->with('success', trans('settings.marketplace.update'));
    }
}
