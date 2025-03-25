<?php

namespace App\Console\Commands\Subscriptions;

use App\Services\Subscription\SubscriptionEndService;
use Illuminate\Console\Command;

class EndSubscriptions extends Command
{
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
    protected $description = 'End custom subscriptions (sofort) that have expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var SubscriptionEndService $service */
        $service = app()->make(SubscriptionEndService::class);

        $fake = $this->argument('fake');

        $count = $service->run($fake === 'false');
        $this->info('Ended ' . $count . ' subscriptions.');

        return 0;
    }
}
