<?php

namespace App\Services\Users;

use App\Models\UserLog;

class UserLogService
{
    public function deleteOldLogs(): self
    {
        UserLog::where('created_at', '<=', \Carbon\Carbon::today()->subDays(30)->format('Y-m-d'))
            ->update(['ip' => null, 'country' => null]);

        return $this;
    }
}
