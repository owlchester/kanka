<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Users\UserLogService;
use App\Models\JobLog;

class AnonymiseUserLogs extends Command
{
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

    protected UserLogService $service;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserLogService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service->deleteOldLogs();

        $log = "Cleaned up user logs PII.";
        $this->info($log);

        if (!config('app.log_jobs')) {
            return 0;
        }

        JobLog::create([
            'name' => $this->signature,
            'result' => $log,
        ]);
        return 0;
    }
}
