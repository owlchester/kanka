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
     * The recovery service
     *
     */
    protected PurgeService $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PurgeService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->service->purgeDeleted();
        $this->info('');
        $this->info('Deleted ' . $this->service->count() . ' trashed campaigns.');

        return 0;
    }
}
