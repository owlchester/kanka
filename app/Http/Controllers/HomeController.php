<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Models\Character;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Release;
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
        if (empty($campaign) || !isset($campaign) || Auth::user()->campaign()->count() == 0) {
            return redirect()->route('campaigns.index');
        }

        $notes = Note::acl(Auth::user())->dashboard()->get();
        $settings = Auth::user()->dashboardSetting;
        $campaign = Campaign::findOrFail(Session::get('campaign_id'));
        $characters = Character::acl(Auth::user())->recent()->take($settings->recent_count)->get();
        $families = Family::acl(Auth::user())->recent()->take($settings->recent_count)->get();
        $locations = Location::acl(Auth::user())->recent()->take($settings->recent_count)->get();
        $items = Item::acl(Auth::user())->recent()->take($settings->recent_count)->get();
        $organisations = Organisation::acl(Auth::user())->recent()->take($settings->recent_count)->get();
        $journals = Journal::acl(Auth::user())->recent()->take($settings->recent_count)->get();

        //$characters = Character::

        $release = Release::with(['category'])
            ->where('status', 'PUBLISHED')
            ->orderBy('created_at', 'DESC')
            ->first();

        return view('home', compact(
            'campaign',
            'notes',
            'characters',
            'families',
            'locations',
            'items',
            'journals',
            'organisations',
            'settings',
            'release'
        ));
    }
}
