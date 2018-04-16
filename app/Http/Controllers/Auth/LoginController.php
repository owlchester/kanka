<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->last_campaign_id) {
            // The user should be part of the last campaign
            if (!CampaignService::isUserPartOfCurrentCampaign()) {
                // If not we flush it
                CampaignService::flushCurrentCampaign();
                // And switch to next
                CampaignService::switchToNext();
                // If the campaign_id has been forgotten
                if (!Session::get('campaign_id')) {
                    // The user do not have any campaign
                    // So we invite him to create a campaign
                    return redirect()->route('campaigns.create');
                }
            }
        }
    }
}
