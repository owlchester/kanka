<?php

namespace App\Services\Users;

use App\Models\UserLog;
use Carbon\Carbon;

class UserLogService
{
    protected int $count;

    public function count(): int
    {
        return $this->count;
    }

    public function anonymize(): self
    {
        $cutoff = config('logging.anonymize');
        $this->count = UserLog::whereDate('created_at', Carbon::today()->subDays($cutoff)->format('Y-m-d'))
            ->update(['ip' => null, 'country' => null]);

        return $this;
    }
}
