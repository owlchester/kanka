<?php

namespace App\Console\Commands;

use App\Models\CalendarEvent;
use App\Models\EntityEvent;
use App\Models\Location;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCalendarEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move the calendar events to entity events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;
        foreach (CalendarEvent::with('event')->with('entity')->get() as $event) {
            $count++;

            $new = new EntityEvent();
            $new->calendar_id = $event->calendar_id;
            $new->entity_id = $event->event->entity->id;
            $new->date = $event->date;
            $new->is_recurring = false;
            $new->save();
        }
        $this->info("Moved $count events.");
    }
}
