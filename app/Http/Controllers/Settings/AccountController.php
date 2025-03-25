<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'password.confirm']);
    }

    public function index()
    {
        $user = auth()->user();

        return view('settings.account')
            ->with(compact('user'));
    }
}
