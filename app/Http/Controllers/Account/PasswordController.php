<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsAccount;
use App\Jobs\Users\NewPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('password.confirm');
    }

    public function index()
    {
        return view('account.password.form')->with('user', auth()->user());
    }

    public function save(StoreSettingsAccount $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = [
            'password' => Hash::make($request->post('password_new')),
        ];
        auth()->user()->update($data);
        NewPassword::dispatch(auth()->user());

        Auth::logoutOtherDevices($request->get('password_new'));

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.password_success'));
    }
}
