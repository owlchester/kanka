<?php

namespace App\Http\Controllers;

class BugReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index()
    {
        return view('helpers.bug-report.index');
    }
}
