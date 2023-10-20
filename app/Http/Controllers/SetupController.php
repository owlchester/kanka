<?php

namespace App\Http\Controllers;

class SetupController extends Controller
{
    public function index()
    {
        if (!app()->isLocal()) {
            return abort(404);
        }
        return view('setup');
    }
}
