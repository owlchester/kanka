<?php

namespace App\Observers;

use App\Models\UserLog;

class UserLogObserver
{
    public function creating(UserLog $userLog)
    {
        $userLog->ip = request()->ip();
        // In prod, requests come from our load balancers, so the real user ip is provided by Cloudflare.
        $ip = request()->server('HTTP_CF_CONNECTING_IP');
        if (! empty($ip)) {
            $userLog->ip = $ip;
            // While we're at it, track the user's country. All of this data is purged after 30 days.
            $userLog->country = mb_substr(request()->server('HTTP_CF_IPCOUNTRY'), 0, 6);
        }
    }
}
