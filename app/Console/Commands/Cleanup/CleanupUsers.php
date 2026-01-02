<?php

namespace App\Console\Commands\Cleanup;

use App\Services\Users\PurgeService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:purge {dry=0} {limit=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge accounts';

    public function __construct(protected PurgeService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info(Carbon::now());

        $dry = $this->argument('dry');
        if ($dry === '0') {
            $this->service->real();
        }
        $limit = (int) $this->argument('limit');
        $this->service->limit($limit);

        /*
        $cutoff = Carbon::now()->subYears(1);

        $count = $service->date($cutoff)->empty();
        $this->info(Carbon::now() . ': Empty scheduled ' . $count . ' users for cleanup.');

        $cutoff = Carbon::now()->subYears(2);
        $count = $service->date($cutoff)->example();
        $this->info(Carbon::now() . ': Example  scheduled ' . $count . ' users for cleanup.');
         */

        $count = $this->service->firstWarning();
        $this->info(Carbon::now() . ': ' . $count . ' inactive users notified (first warning)');

        $count = $this->service->secondWarning();
        $this->info(Carbon::now() . ': ' . $count . ' inactive users notified (second warning)');

        $count = $this->service->purge();
        $this->info(Carbon::now() . ': ' . $count . ' inactive users purged');
    }
}
