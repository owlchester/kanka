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
        $userLog->ip = request()->ip();
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $userLog->ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) {
            $userLog->country = substr($_SERVER["HTTP_CF_IPCOUNTRY"], 0, 6);
        }
    }
}
