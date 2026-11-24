<?php

namespace App\Console\Commands\Cleanup;

use App\Services\Campaign\PurgeService;
use App\Traits\HasJobLog;
use Illuminate\Console\Command;

class CleanupTrashedCampaigns extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:trashed-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old trashed campaigns';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected PurgeService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->service->purgeDeleted();
        $log = 'Deleted ' . $count . ' trashed campaigns.';
        $this->info($log);
        $this->log($log . ' ' . implode(',', $this->service->ids()));

        return 0;
    }
}
