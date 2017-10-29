<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaign = Campaign::findOrFail(Session::get('campaign_id'));
        //$characters = Character::

        return view('home', compact('campaign'));
    }
}
