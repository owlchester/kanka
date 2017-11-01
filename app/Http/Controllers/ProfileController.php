<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('profiles.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProfile $request)
    {
        Auth::user()->update($request->only('name', 'email', 'password_new', 'newsletter'));
        return redirect()->route('profile');
    }
}
