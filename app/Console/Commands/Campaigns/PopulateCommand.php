<?php

namespace App\Console\Commands\Campaigns;

use App\Jobs\Campaigns\Populate;
use App\Models\Campaign;
use App\Services\StarterService;
use Illuminate\Console\Command;

class PopulateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:populate {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate a campaign with the starter kit';

    protected StarterService $starterService;

    public function __construct(StarterService $starterService)
    {
        $this->starterService = $starterService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaignId = $this->argument('campaign');
        $campaign = Campaign::where('id', $campaignId)->first();
        if ($campaign) {
            Populate::dispatch($campaign);
        } else {
            $this->info('Invalid campaign ID');
        }
    }
}
