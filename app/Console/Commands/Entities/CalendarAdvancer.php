<?php

namespace App\Console\Commands\Entities;

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;
use App\Services\Calendars\AdvancerService;
use App\Traits\HasJobLog;
use Exception;
use Illuminate\Console\Command;

class CalendarAdvancer extends Command
{
    use HasJobLog;

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

    /** Calendars that were advanced */
    protected int $count = 0;

    /** Errors that happened */
    protected array $errors = [];

    protected AdvancerService $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AdvancerService $advancerService)
    {
        $this->service = $advancerService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Calendar::where('is_incrementing', true)->chunkById(500, function ($calendars): void {
            /** @var Calendar $calendar */
            foreach ($calendars as $calendar) {
                try {
                    $this->service->calendar($calendar)->advance();
                    // Consoles don't have observers at the moment because Jay makes terrible life choices
                    CalendarsClearElapsed::dispatch($calendar);
                    $this->count++;
                } catch (Exception $e) {
                    $this->errors[$calendar->id] = $e->getMessage();
                }
            }
        });

        $log = "Advanced {$this->count} calendars.";
        $this->info($log);

        if (! empty($this->errors)) {
            $this->error('Errors for ' . count($this->errors) . ' calendars.');
            $this->error(implode(', ', array_keys($this->errors)));

            $log .= '<br />' . 'Errors for ' . count($this->errors) . ' calendars.';
            $log .= '<br />' . implode(', ', array_keys($this->errors));
        }
        $this->log($log);

        return 0;
    }
}
