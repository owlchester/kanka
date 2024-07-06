<?php

namespace App\Observers;

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;
use App\Models\MiscModel;

class CalendarObserver extends MiscObserver
{
    public function saved(MiscModel $model)
    {
        parent::saved($model);
        if ($model->isDirty(['date'])) {
            /** @var Calendar $model */
            CalendarsClearElapsed::dispatch($model);
        }
    }
}
