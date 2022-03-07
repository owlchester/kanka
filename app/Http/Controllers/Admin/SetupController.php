<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SetupController extends Controller
{
    public function index()
    {
        return view('admin.setup.index');
    }
}
