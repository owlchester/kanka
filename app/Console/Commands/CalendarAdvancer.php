<?php

namespace App\Console\Commands;

use App\Models\Calendar;
use App\Models\JobLog;
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

    /** @var int Calendars that were advanced */
    protected int $count = 0;

    /** @var array Errors that happened */
    protected array $errors = [];

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
     * @return bool
     */
    public function handle()
    {
        Calendar::where('is_incrementing', true)->chunk(500, function ($calendars) {
            /** @var Calendar $calendar*/
            foreach ($calendars as $calendar) {
                try {
                    $calendar->addDay();
                    $this->count++;
                } catch (\Exception $e) {
                    $this->errors[$calendar->id] = $e->getMessage();
                }
            }
        });

        $log = "Advanced {$this->count} calendars.";
        $this->info($log);

        if (!empty($this->errors)) {
            $this->error('Errors for ' . count($this->errors) . ' calendars.');
            $this->error(implode(', ', array_keys($this->errors)));

            $log .= '<br />' . 'Errors for ' . count($this->errors) . ' calendars.';
            $log .= '<br />' . implode(', ', array_keys($this->errors));
        }

        if (!config('app.log_jobs')) {
            return 0;
        }

        JobLog::create([
            'name' => 'calendar-advancer',
            'result' => $log,
        ]);

        return 0;
    }
}
