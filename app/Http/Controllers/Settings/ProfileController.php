<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsProfile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('settings.profile', compact('user'));
    }

    public function update(StoreSettingsProfile $request)
    {
        if ($request->ajax()) {
            return response()->json();
        }
        /** @var User $user */
        $user = $request->user();

        $user->saveSettings($request->only(['settings.hide_subscription', 'settings.marketplace_name', 'settings.pronouns', 'settings.link']))
            ->update($request->only('name', 'has_last_login_sharing', 'avatar', 'profile'));

        return redirect()
            ->route('settings.profile')
            ->with('success', trans('settings.profile.success'));
    }
}
