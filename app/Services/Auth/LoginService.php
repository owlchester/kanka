<?php

namespace App\Services\Auth;

use App\Models\UserFlag;
use App\Models\UserLog;
use App\Traits\UserAware;
use Carbon\Carbon;

class LoginService
{
    use UserAware;

    public function logUserActivity(): self
    {
        $action = auth()->viaRemember() ? UserLog::TYPE_AUTOLOGIN : UserLog::TYPE_LOGIN;
        $userLogType = session()->get('kanka.userLog', $action);
        if ($this->user->isBanned()) {
            $userLogType = session()->get('kanka.userLog', UserLog::TYPE_BANNED_LOGIN);
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
            ->whereIn('flag', [UserFlag::FLAG_INACTIVE_1, UserFlag::FLAG_INACTIVE_2])
            ->delete();

        return $this;
    }
}
