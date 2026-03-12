<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

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
     * @return Factory|View
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
