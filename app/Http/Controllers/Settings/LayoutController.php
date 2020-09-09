<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsLayout;
use Illuminate\Support\Facades\Auth;

class LayoutController extends Controller
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
        return view('settings.layout');
    }

    /**
     * @param StoreSettingsLayout $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreSettingsLayout $request)
    {
        Auth::user()
            ->saveSettings($request->only(['editor', 'default_nested', 'advanced_mentions', 'new_entity_workflow']))
            ->update($request->only(['theme', 'default_pagination', 'date_format']));

        return redirect()
            ->route('settings.layout')
            ->with('success', trans('settings.layout.success'));
    }
}
