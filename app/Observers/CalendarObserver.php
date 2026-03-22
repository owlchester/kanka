<?php

namespace App\Observers;

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;
use App\Models\MiscModel;

class CalendarObserver
{
    public function saved(MiscModel $model)
    {
        if ($model->isDirty(["date"])) {
            /** @var Calendar $model */
            CalendarsClearElapsed::dispatch($model);
        }
    }
}
