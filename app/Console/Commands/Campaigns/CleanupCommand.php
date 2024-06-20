<?php

namespace App\Console\Commands\Campaigns;

use App\Models\Campaign;
use App\Observers\CampaignObserver;
use App\Services\Campaign\PurgeService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:cleanup {dry=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete empty campaigns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(Carbon::now());
        Campaign::observe(CampaignObserver::class);

        /** @var PurgeService $service */
        $service = app()->make(PurgeService::class);

        $dry = $this->argument('dry');
        if ($dry === '0') {
            $service->real();
        }

        $count = $service->purgeEmpty();

        if ($dry === '0') {
            $this->info(Carbon::now() . ': Deleted ' . $count . ' empty campaigns.');
        } else {
            $this->info(Carbon::now() . ': There are ' . $count . ' empty campaigns that can be deleted.');
        }
    }
}
