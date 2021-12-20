<?php

namespace App\Observers;

use App\Models\UserLog;

class UserLogObserver
{
    /**
     * @param UserLog $userLog
     */
    public function creating(UserLog $userLog)
    {
        $ip = request()->ip();
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        $userLog->ip = $ip;
    }
}
