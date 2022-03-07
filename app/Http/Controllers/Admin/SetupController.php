<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SetupController extends Controller
{
    public function index()
    {
        if (auth()->user()->id !== 1) {
            return redirect()->route('admin.home');
        }
        return view('admin.setup.index');
    }
}
