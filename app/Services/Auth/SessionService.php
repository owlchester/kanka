<?php

namespace App\Services\Auth;

use App\Services\InviteService;
use App\Services\StarterService;
use App\Services\Users\CampaignService;
use App\Traits\UserAware;
use Exception;

class SessionService
{
    use UserAware;

    public function __construct(
        protected InviteService $inviteService,
        protected StarterService $starterService,
        protected CampaignService $campaignService
    ) {}

    public function handleInviteToken(): ?bool
    {
        // Does the user have a join campaign token?
        if (! session()->has('invite_token')) {
            return null;
        }
        try {
            $campaign = $this->inviteService
                ->user($this->user)
                ->useToken(session()->get('invite_token'));
            $this->campaignService
                ->user($this->user)
                ->campaign($campaign)
                ->set();

            return true;
        } catch (Exception $e) {
            // Silence errors here
            return false;
        }
    }

    public function handleFirstLogin(): ?bool
    {
        if (! session()->has('first_login')) {
            return null;
        }
        try {
            $this->starterService
                ->user($this->user)
                ->create();
            session()->remove('first_login');

            return true;
        } catch (Exception $e) {
            // Log exception or handle it properly
            return false;
        }

    }
}
