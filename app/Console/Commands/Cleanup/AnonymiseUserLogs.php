<?php

namespace App\Console\Commands\Cleanup;

use App\Services\Users\UserLogService;
use App\Traits\HasJobLog;
use Illuminate\Console\Command;

class AnonymiseUserLogs extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:anonymise-user-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anonymise User logs older than 30 days';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected UserLogService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service->anonymize();

        $log = 'Cleaned up ' . $this->service->count() . ' logs PII.';
        $this->info($log);
        $this->log($log);

        return 0;
    }
}
