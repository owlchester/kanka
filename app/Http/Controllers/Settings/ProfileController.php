<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return view('settings.profile', compact('user'));
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreSettingsProfile $request)
    {
        /** @var User $user */
        $user = $request->user();
        $settings = $user->settings();
        if ($user->isPatron() && $request->has('settings.hide_subscription') && $request->input('settings.hide_subscription') == '1') {
            $settings->put('hide_subscription', true);
        } else {
            $settings->forget('hide_subscription');
        }
        $user->settings = $settings;

        $user->update($request->only('name', 'has_last_login_sharing', 'avatar', 'profile'));

        return redirect()
            ->route('settings.profile')
            ->with('success', trans('settings.profile.success'));
    }
}
