<?php

namespace App\Console\Commands\Users;

use App\Services\Users\OfferTrialService;
use Illuminate\Console\Command;

class OfferFreeTrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:trial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Offer a free trial to some users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var OfferTrialService $service */
        $service = app()->make(OfferTrialService::class);
        $count = $service->run();
        $this->info('Offered free trial to ' . $count . ' users.');
    }
}
