<?php

namespace App\Http\Controllers;

use App\Exceptions\RequireLoginException;
use App\Models\User;
use App\Services\InviteService;
use Exception;

class InvitationController extends Controller
{
    protected InviteService $inviteService;

    protected \App\Services\Users\CampaignService $campaignService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InviteService $inviteService, \App\Services\Users\CampaignService $campaignService)
    {
        $this->inviteService = $inviteService;
        $this->campaignService = $campaignService;
    }

    /**
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join($token)
    {
        try {
            if (auth()->check()) {
                $this->inviteService
                    ->user(auth()->user());
            }
            $campaign = $this->inviteService
                ->useToken($token);
            $this->campaignService
                ->user(auth()->user())
                ->campaign($campaign)
                ->set();

            return redirect()->to('/');
        } catch (RequireLoginException $e) {
            return redirect()->route('login')->with('info', $e->getMessage());
        } catch (Exception $e) {
            if (auth()->guest()) {
                return redirect()->route('login')->withErrors($e->getMessage());
            }
            // Let's redirect the user to their first campaign, to handle the error message, or on start otherwise
            $campaign = auth()->user()->campaigns->first();
            if (! $campaign) {
                return redirect()->route('start')->withError($e->getMessage());
            }

            return redirect()
                ->route('dashboard', $campaign)
                ->withError($e->getMessage());
        }
    }
}
