<?php

namespace App\Observers;

use App\Jobs\CalendarsClearElapsed;
use App\Models\MiscModel;

class CalendarObserver extends MiscObserver
{
    public function updated(MiscModel $model)
    {
        if ($model->isDirty(['date'])) {
            CalendarsClearElapsed::dispatch($model);
        }
    }
}
