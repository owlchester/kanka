<?php

namespace App\Traits;

use App\Models\JobLog;

trait HasJobLog
{
    protected function log(mixed $data)
    {
        if (! config('app.log_jobs')) {
            return;
        }

        JobLog::create([
            'name' => $this->signature,
            'result' => $data,
        ]);
    }
}
