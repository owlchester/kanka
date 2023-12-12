<?php

namespace App\Jobs;

use App\Models\Calendar;
use App\Models\EntityEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CalendarsClearElapsed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $id;
    /**
     * Create a new job instance.
     */
    public function __construct(Calendar $calendar)
    {
        $this->id = $calendar->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $calendar = Calendar::find($this->id);
        if (!$calendar) {
            return;
        }

        $model = new EntityEvent();
        DB::update('UPDATE ' . $model->getTable() . ' SET elapsed = NULL WHERE calendar_id = \'' . $calendar->id . '\'');
    }
}
