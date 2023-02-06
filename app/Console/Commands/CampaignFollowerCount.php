<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;

class CampaignFollowerCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:followers';

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
        // @phpstan-ignore-next-line
        Campaign::public()->with('followers')->chunk(500, function ($campaigns): void {
            foreach ($campaigns as $campaign) {
                $this->processCampaign($campaign);
                $this->count++;
            }
        });

        $this->info('Updated ' . $this->count . ' campaign followers.');
        return 0;
    }

    /**
     * @param Campaign $campaign
     * @return void
     */
    protected function processCampaign(Campaign $campaign): void
    {
        $campaign->follower = $campaign->followers->count();
        $campaign->updateQuietly(['follower']);
    }
}
