<?php

namespace App\Http\Controllers;

class SetupController extends Controller
{
    public function index()
    {
        if (!config('app.debug')) {
            return abort(404);
        }
        return view('setup');
    }
}
