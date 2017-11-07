<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Character;
use App\Family;
use App\Item;
use App\Journal;
use App\Location;
use App\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $this->middleware('auth', ['only' => ['back']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()) {
            return $this->front();
        } else {
            return $this->back();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function front()
    {
        return view('front.home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function back()
    {
        $campaign = Session::get('campaign_id');
        if (empty($campaign)) {
            return redirect()->route('campaigns.index');
        }

        $campaign = Campaign::findOrFail(Session::get('campaign_id'));
        $characters = Character::recent()->take(5)->get();
        $families = Family::recent()->take(5)->get();
        $locations = Location::recent()->take(5)->get();
        $items = Item::recent()->take(5)->get();
        $organisations = Organisation::recent()->take(5)->get();
        $journals = Journal::recent()->take(3)->get();

        //$characters = Character::

        return view('home', compact('campaign', 'characters', 'families',
            'locations', 'items', 'journals', 'organisations'));
    }
}
