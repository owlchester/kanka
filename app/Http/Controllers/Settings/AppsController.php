<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;

class AppsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.apps');
    }
}
