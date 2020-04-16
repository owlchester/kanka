<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\RecoveryService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupTrashed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:trashed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old trashed entities';

    /**
     * The recovery service
     *
     * @var RecoveryService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RecoveryService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = $this->service->cleanup();
        $this->info('Deleted ' . $count . ' trashed entities.');
    }
}
