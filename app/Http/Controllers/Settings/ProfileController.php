<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsProfile;
use App\Jobs\Emails\MailSettingsChangeJob;
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
        $this->middleware(['auth', 'identity', 'shadow']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.profile');
    }

    /**
     * @param StoreProfile $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreSettingsProfile $request)
    {
        Auth::user()
            ->saveSettings($request->only([ 'mail_newsletter', 'mail_release', 'mail_vote']))
            ->update($request->only('name', 'has_last_login_sharing', 'avatar'));

        MailSettingsChangeJob::dispatch($request->user());

        return redirect()
            ->route('settings.profile')
            ->with('success', trans('settings.profile.success'));
    }
}
