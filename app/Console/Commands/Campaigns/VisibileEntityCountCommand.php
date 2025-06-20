<?php

namespace App\Console\Commands\Campaigns;

use App\Models\Campaign;
use App\Services\Campaign\Counters\VisibleEntityCountService;
use App\Traits\HasJobLog;
use Illuminate\Console\Command;

class VisibileEntityCountCommand extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the visible entity count for public campaigns';

    /** @var int Number of processed elements */
    protected int $count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected VisibleEntityCountService $countService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Campaign::public()->chunk(1000, function ($campaigns): void {
            /** @var Campaign $campaign */
            foreach ($campaigns as $campaign) {
                $this->count++;
                $this->countService->campaign($campaign)->process();
            }
        });
        $log = "Updated {$this->count} public campaigns.";
        $this->info($log);
        $this->log($log);
    }
}
