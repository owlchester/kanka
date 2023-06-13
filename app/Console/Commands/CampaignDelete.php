<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Jobs\CampaignDeleteJob;
use Illuminate\Console\Command;


class CampaignDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:delete {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a specified campaign';

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
        $campaignId = $this->argument('campaign');
        $campaign = Campaign::where('id', $this->argument('campaign'))->first();

        CampaignDeleteJob::dispatch($campaign);

        return 0;
    }
}