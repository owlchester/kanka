<?php

namespace App\Console\Commands\Users;

use App\Services\Users\OfferTrialService;
use App\Traits\HasJobLog;
use Illuminate\Console\Command;

class OfferFreeTrial extends Command
{
    use HasJobLog;

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
        $log = 'Offered free trial to ' . $count . ' users.';
        $this->info($log);
        $this->log($log . ' ' . implode(',', $this->service->ids()));
    }
}
