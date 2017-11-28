<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserDashboardSetting;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('dashboard.settings.setting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserDashboardSetting $request)
    {
        $setting = Auth::user()->dashboardSetting;
        $setting->update($request->all());
        return redirect()->route('home')->with('success', trans('dashboard.settings.edit.success'));
    }
}
