<?php

namespace App\Services\Auth;

use App\Enums\UserAction;
use App\Enums\UserFlags;
use App\Models\UserFlag;
use App\Models\Users\Tutorial;
use App\Traits\UserAware;
use Carbon\Carbon;

class LoginService
{
    use UserAware;

    public function logUserActivity(): self
    {
        $action = auth()->viaRemember() ? UserAction::autoLogin : UserAction::login;
        $userLogType = session()->get('kanka.userLog', $action);
        if ($this->user->isBanned()) {
            $userLogType = session()->get('kanka.userLog', UserAction::bannedLogin);
        }
        $this->user->log($userLogType);
        session()->remove('kanka.userLog');

        return $this;
    }

    public function updateLastLoginTime(): self
    {
        $this->user->updateQuietly(['last_login_at' => Carbon::now()]);

        return $this;
    }

    public function clearInactivityFlag(): self
    {
        // Delete any flags to auto-delete the account based on inactivity
        UserFlag::where('user_id', $this->user->id)
            ->whereIn('flag', [UserFlags::firstWarning->value, UserFlags::secondWarning->value])
            ->delete();

        return $this;
    }

    public function loadFlags(): self
    {
        $flag = $this->user->can('freeTrial', $this->user);
        if ($flag) {
            // If the user "dismissed" the tutorial 2 or more days ago, cancel that
            $this->user->tutorials()
                ->where('code', 'banner_free_trial')
                ->whereDate('created_at', '<', Carbon::now()->subDays(2))
                ->delete();
            session()->put('kanka.freeTrial', true);
        }
        return $this;
    }
}
