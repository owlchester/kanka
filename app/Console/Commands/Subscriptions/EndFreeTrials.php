<?php

namespace App\Console\Commands\Subscriptions;

use App\Services\Subscription\FreeTrialEndService;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EndFreeTrials extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:end-free-trials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End free trials';

    public function __construct(protected FreeTrialEndService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->service->run();
        // $this->info(Carbon::now()->subMinute()->startOfMinute() . ' and ' . Carbon::now()->subMinute()->endOfMinute());
        $log = 'Ended ' . $count . ' free trials.';
        $this->info($log);
        $this->log($log . ' ' . implode(',', $this->service->ids()));

        return 0;
    }
}
