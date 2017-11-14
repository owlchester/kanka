<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteProfile;
use App\Http\Requests\StoreProfile;
use App\Http\Requests\StoreProfilePassword;
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
        return redirect()->route('profile')->with('success', trans('profiles.edit.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
     */
    public function password(StoreProfilePassword $request)
    {
        Auth::user()->update($request->only('password_new'));
        return redirect()->route('profile')->with('success', trans('profiles.password.success'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteProfile $request)
    {
        $user = Auth::user();
        $user->delete();
        return redirect()->route('home');
    }
}
