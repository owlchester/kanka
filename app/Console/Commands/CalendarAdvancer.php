<?php

namespace App\Console\Commands;

use App\Models\Calendar;
use App\Models\Campaign;
use Illuminate\Console\Command;

class CalendarAdvancer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:advance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment the date of all advancing calendars.';

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Calendar::where('is_incrementing', true)->chunk(500, function ($calendars) {
            /** @var Calendar $calendar*/
            foreach ($calendars as $calendar) {
                $calendar->addDay();
                $this->count++;
            }
        });

        $this->info("Advanced {$this->count} calendars.");

        return true;
    }
}
