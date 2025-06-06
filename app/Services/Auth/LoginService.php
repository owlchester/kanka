<?php

namespace App\Services\Auth;

use App\Enums\UserAction;
use App\Models\UserFlag;
use App\Models\UserLog;
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
            ->whereIn('flag', [\App\Enums\UserFlag::firstWarning->value, \App\Enums\UserFlag::secondWarning->value])
            ->delete();

        return $this;
    }
}
