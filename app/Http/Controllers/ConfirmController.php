<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class ConfirmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $route = request()->get('route');
        $name = request()->get('name');
        $permanent = request()->has('permanent');
        $mirrored = request()->get('mirrored', false);

        return view('confirms.delete')
            ->with('route', $route)
            ->with('name', $name)
            ->with('mirrored', $mirrored)
            ->with('permanent', $permanent);
    }
}
