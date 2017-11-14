<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignUser;
use App\Exceptions\RequireLoginException;
use App\Models\CampaignInvite;
use App\Services\CampaignService;
use App\Services\InviteService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InvitationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // No auth!
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join($token)
    {
        try {
            $campaign = InviteService::useToken($token);
            CampaignService::switchCampaign($campaign);
            return redirect()->to('/');
        } catch (RequireLoginException $e) {
            return redirect()->route('login')->with('info', $e->getMessage());
        } catch (\Exception $e) {
            if (Auth::guest()) {
                return redirect()->route('login')->withErrors($e->getMessage());
            } else {
                return redirect()->route('home')->withErrors($e->getMessage());
            }
        }
    }
}
