<?php

namespace App\Http\Controllers\Datagrids;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('datagrids.subscription');
    }
}
