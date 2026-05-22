<?php

namespace App\Observers;

use App\Models\UserLog;
use App\Services\Auth\IpResolver;

class UserLogObserver
{
    public function __construct(protected IpResolver $ipResolver) {}

    public function creating(UserLog $userLog): void
    {
        $userLog->ip = $this->ipResolver->resolve();
        $userLog->country = mb_substr(request()->server('HTTP_CF_IPCOUNTRY') ?? '', 0, 6) ?: null;
    }
}
