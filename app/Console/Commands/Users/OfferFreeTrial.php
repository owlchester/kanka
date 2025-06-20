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

    public function __construct(protected OfferTrialService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->service->run();
        $this->info('Offered free trial to ' . $count . ' users.');
    }
}
