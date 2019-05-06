<?php

namespace App\Console\Commands;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\EntityEvent;
use App\Models\Location;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:moons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix moon json to the new (2019.05) format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;
        /** @var Calendar $calendar */
        foreach (Calendar::get() as $calendar) {
            if (empty($calendar->moons())) {
                continue;
            }

            $count++;

            $newMoons = [];
            foreach ($calendar->moons() as $fullmoon => $moon) {
                $newMoons[] = [
                    'name' => $moon,
                    'fullmoon' => $fullmoon,
                    'offset' => 0
                ];
            }

            $calendar->moons = json_encode($newMoons);
            $calendar->savingObserver = false;
            $calendar->save();
        }
        $this->info("Updated $count calendars.");
    }
}
