<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Patreon\API;
use Patreon\OAuth;

class PatreonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.patreon');
    }

    public function callback(Request $request)
    {
        $clientId = env('PATREON_CLIENT_ID');
        $clientSecret = env('PATREON_CLIENT_SECRET');
        $redirectUri = link_to('/settings/patreon_callback');

        $oauth = new OAuth($clientId, $clientSecret);

        $tokens = $oauth->get_tokens($request->get('code'), $redirectUri);
        dd($tokens);

        $api = new API($tokens['access_token']);
        $patreon = $api->fetch_user();
        $patron = $patreon->get('data');

        dd($patron);

        if ($patron->has('relationships.pledges')) {

        }

        dd($request->all());
    }
}
