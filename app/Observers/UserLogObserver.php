<?php

namespace App\Observers;

use App\Models\UserLog;
use App\Services\Auth\IpResolver;

class UserLogObserver
{
    public function creating(UserLog $userLog): void
    {
        $resolver = app(IpResolver::class);
        $userLog->ip = $resolver->resolve();
        $userLog->country = mb_substr(request()->server('HTTP_CF_IPCOUNTRY') ?? '', 0, 6) ?: null;
    }
}
