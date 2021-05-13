<?php

namespace App\Console\Commands;

use App\Models\Calendar;
use Illuminate\Console\Command;

class UpdateMoons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendars:moons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give moons an id for periodicity';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Updating calendar moons...');
        Calendar::whereNotNull('moons')->chunk(500, function ($calendars) {
            foreach ($calendars as $calendar) {
                if (empty($calendar->moons)) {
                    continue;
                }
                $new = [];
                $moons = $calendar->moons();
                $i = 1;
                foreach ($moons as $moon) {
                    $moon['id'] = $i;
                    $i++;
                    $new[] = $moon;
                }

                $calendar->moons = $new;
                $calendar->savingObserver = false;
                $calendar->update(['moons']);
                $this->count++;
            }
        });

        $this->info('Updated ' . $this->count . ' calendars');
        return 0;
    }
}
