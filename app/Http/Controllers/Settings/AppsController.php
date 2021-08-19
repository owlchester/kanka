<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.apps');
    }
}
