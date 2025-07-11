<?php

namespace App\Services;

use App\Enums\UserAction;
use App\Events\Campaigns\Members\Switched;
use App\Models\CampaignUser;
use App\Models\User;
use App\Traits\CampaignAware;
use Exception;
use Illuminate\Foundation\Application;

class IdentityManager
{
    use CampaignAware;

    /**
     * @var Application
     */
    private $app;

    /**
     * IdentityManager constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function switch(CampaignUser $campaignUser): bool
    {
        try {
            Switched::dispatch($campaignUser->campaign, auth()->user(), $campaignUser);

            // Save the current user in the session to know we have limitation on the current user.
            session()->put($this->getSessionKey(), $this->app['auth']->user()->id);
            session()->put($this->getSessionCampaignKey(), $this->campaign->id);

            // Log this action
            session()->put('kanka.userLog', UserAction::userSwitchLogin);
            $this->app['auth']->loginUsingId($campaignUser->user->id);
        } catch (Exception $e) {
            return false;
        }

        // Dispatch a log for the user?

        return true;
    }

    public function back(): bool
    {
        // Not actually impersonating anyone? Sure.
        if (! $this->isImpersonating()) {
            return false;
        }

        try {
            // $impersonated = $this->app['auth']->user();
            $impersonator = $this->findUserById($this->getImpersonatorId());

            session()->put('kanka.userLog', UserAction::userRevert);

            $this->app['auth']->loginUsingId($impersonator->id);
            $this->clear();
        } catch (Exception $e) {
            return false;
        }

        // Dispatch a log for the user?

        return true;
    }

    /**
     * Determine if we are someone else that we usually are.
     */
    public function isImpersonating(): bool
    {
        return session()->has($this->getSessionKey());
    }

    protected function findUserById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * The Key used to determine where our original user is stored
     */
    public function getSessionKey(): string
    {
        return 'kanka.originalUserID';
    }

    /**
     * The Key used to determine where our original campaign is stored
     */
    public function getSessionCampaignKey(): string
    {
        return 'kanka.originalCampaignID';
    }

    public function getImpersonatorId()
    {
        return session($this->getSessionKey(), null);
    }

    public function getCampaignId()
    {
        return session($this->getSessionCampaignKey(), null);
    }

    /**
     * Forget the saved user identity.
     */
    protected function clear(): bool
    {
        session()->forget($this->getSessionKey());
        session()->forget($this->getSessionCampaignKey());

        return true;
    }
}
