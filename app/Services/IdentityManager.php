<?php

namespace App\Services;

use App\Models\CampaignUser;
use App\Models\UserLog;
use App\User;
use Illuminate\Foundation\Application;
use \App\Facades\CampaignLocalization;


class IdentityManager
{
    /**
     * @var Application
     */
    private $app;

    /**
     * IdentityManager constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param CampaignUser $campaignUser
     * @return bool
     */
    public function switch(CampaignUser $campaignUser): bool
    {
        try {
            // Save the current user in the session to know we have limitation on the current user.
            session()->put($this->getSessionKey(), $this->app['auth']->user()->id);
            session()->put($this->getSessionCampaignKey(), CampaignLocalization::getCampaign()->id);

            // Log this action
            UserLog::create([
                'user_id' => auth()->user()->id,
                'type_id' => UserLog::TYPE_USER_SWITCH,
            ]);
            session()->put('kanka.userLog', UserLog::TYPE_USER_SWITCH_LOGIN);
            $this->app['auth']->loginUsingId($campaignUser->user->id);
        } catch (\Exception $e) {
            return false;
        }

        // Dispatch a log for the user?

        return true;
    }

    /**
     * @return bool
     */
    public function back(): bool
    {
        // Not actually impersonating anyone? Sure.
        if (!$this->isImpersonating()) {
            return false;
        }

        try {
            $impersonated = $this->app['auth']->user();
            $impersonator = $this->findUserById($this->getImpersonatorId());

            session()->put('kanka.userLog', UserLog::TYPE_USER_REVERT);

            $this->app['auth']->loginUsingId($impersonator->id);
            $this->clear();
        } catch (\Exception $e) {
            return false;
        }

        // Dispatch a log for the user?

        return true;
    }

    /**
     * Determine if we are someone else that we usually are.
     * @return bool
     */
    public function isImpersonating(): bool
    {
        return session()->has($this->getSessionKey());
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function findUserById($id): User
    {
        return User::findOrFail($id);
    }

    /**
     * The Key used to determine where our original user is stored
     * @return string
     */
    public function getSessionKey(): string
    {
        return 'kanka.originalUserID';
    }

    /**
     * The Key used to determine where our original campaign is stored
     * @return string
     */
    public function getSessionCampaignKey(): string
    {
        return 'kanka.originalCampaignID';
    }

    /**
     * @param   void
     * @return  int|null
     */
    public function getImpersonatorId()
    {
        return session($this->getSessionKey(), null);
    }

    /**
     * @param   void
     * @return  int|null
     */
    public function getCampaignId()
    {
        return session($this->getSessionCampaignKey(), null);
    }

    /**
     * Forget the saved user identity.
     * @return bool
     */
    protected function clear(): bool
    {
        session()->forget($this->getSessionKey());
        session()->forget($this->getSessionCampaignKey());
        return true;
    }
}
