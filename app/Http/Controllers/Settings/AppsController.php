<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class AppsController extends Controller
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
        return view('settings.apps');
    }
}
