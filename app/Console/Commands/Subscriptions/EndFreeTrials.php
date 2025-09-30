<?php

namespace App\Console\Commands\Subscriptions;

use App\Services\Subscription\FreeTrialEndService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EndFreeTrials extends Command
{
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
        //$this->info(Carbon::now()->subMinute()->startOfMinute() . ' and ' . Carbon::now()->subMinute()->endOfMinute());
        $this->info('Ended ' . $count . ' free trials.');

        return 0;
    }
}
