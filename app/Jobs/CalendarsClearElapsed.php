<?php

namespace App\Jobs;

use App\Models\Calendar;
use App\Models\EntityEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CalendarsClearElapsed implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Calendar $calendar;

    /**
     * Create a new job instance.
     */
    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $model = new EntityEvent;
        DB::update(
            'UPDATE ' . $model->getTable() . ' SET elapsed = NULL ' .
            'WHERE calendar_id = \'' . $this->calendar->id . '\''
        );
    }
}
