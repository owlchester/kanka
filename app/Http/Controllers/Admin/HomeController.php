<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $advanced = request()->has('advanced');
        return view('admin.home.index', compact('advanced'));
    }
}
