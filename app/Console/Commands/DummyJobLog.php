<?php

namespace App\Console\Commands;

use App\Models\JobLog;
use Illuminate\Console\Command;

class DummyJobLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        JobLog::create([
            'name' => $this->signature,
            'result' => '',
        ]);
        return 0;
    }
}
