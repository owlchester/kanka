<?php

namespace App\Console\Commands\Campaigns;

use App\Models\Campaign;
use App\Services\Campaign\Counters\FollowerCountService;
use Illuminate\Console\Command;

class FollowerCountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:followers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate the number of followers on a campaign';

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected FollowerCountService $countService)
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
        // @phpstan-ignore-next-line
        Campaign::public()->withCount('followers')->chunk(1000, function ($campaigns): void {
            foreach ($campaigns as $campaign) {
                $this->countService->campaign($campaign)->process();
                $this->count++;
            }
        });

        $this->info('Updated ' . $this->count . ' campaign followers.');

        return 0;
    }
}
