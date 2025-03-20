<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class BragiController extends Controller
{
    /**
     * AppsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (! auth()->user()->hasTokens()) {
            abort(401);
        }
        $logs = auth()->user()->bragiLogs()->orderByDesc('created_at')->paginate();
        $isAdmin = auth()->user()->hasRole('admin');

        return view('settings.bragi')
            ->with('logs', $logs)
            ->with('isAdmin', $isAdmin);
    }
}
