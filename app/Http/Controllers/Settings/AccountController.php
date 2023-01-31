<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSettingsAccount;
use App\Http\Requests\StoreSettingsAccount;
use App\Http\Requests\StoreSettingsAccountEmail;
use App\Http\Requests\StoreSettingsAccountSocial;
use App\Models\UserLog;
use App\Services\Account\DeletionService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected DeletionService $deletionService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DeletionService $deletionService)
    {
        $this->middleware(['auth', 'identity', 'password.confirm']);
        $this->deletionService = $deletionService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        return view('settings.account')
            ->with(compact('user'));
    }

    /**
     * @param StoreSettingsAccount $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(StoreSettingsAccount $request)
    {
        auth()->user()->update($request->only('password_new'));
        auth()->user()->log(UserLog::TYPE_PASSWORD_UPDATE);

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.password_success'));
    }

    /**
     * @param StoreSettingsAccountEmail $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email(StoreSettingsAccountEmail $request)
    {
        auth()->user()->update($request->only('email'));
        auth()->user()->log(UserLog::TYPE_EMAIL_UPDATE);

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.email_success'));
    }

    /**
     * @param StoreSettingsAccountSocial $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function social(StoreSettingsAccountSocial $request)
    {
        if (empty(auth()->user()->provider)) {
            return redirect()
                ->route('settings.account')
                ->with('error', __('settings.account.social.error'));
        }

        $data['provider'] = null;
        $data['provider_id'] = null;

        auth()->user()->update($data);
        auth()->user()->log(UserLog::TYPE_SOCIAL_SWITCH);

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.social.success'));
    }

    /**
     * @param DeleteSettingsAccount $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeleteSettingsAccount $request)
    {
        $this->deletionService
            ->user($request->user())
            ->delete();
        return redirect()->route('home', ['deleted' => true]);
    }
}
