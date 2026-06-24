<?php

namespace App\Console\Commands\Subscriptions;

use App\Services\Subscription\SubscriptionEndService;
use App\Traits\HasJobLog;
use Illuminate\Console\Command;

class EndSubscriptions extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:end {fake=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End subscriptions that have expired / didn\'t finish paying';

    public function __construct(protected SubscriptionEndService $service)
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
        $fake = $this->argument('fake');

        $count = $this->service->run($fake === 'false');
        $log = 'Ended ' . $count . ' subscriptions.';
        $this->info($log);
        $this->log($log . ' ' . implode(', ', $this->service->ids()));

        return 0;
    }
}
