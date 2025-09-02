<?php

namespace App\Console\Commands\Campaigns;

use App\Events\Campaigns\Bragi\DisabledBragi;
use App\Jobs\Campaigns\Delete;
use App\Jobs\DeletedCampaignCleanupJob;
use App\Models\Campaign;
use Illuminate\Console\Command;

class DeleteCommand extends Command
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
        $campaign = Campaign::where('id', $campaignId)->first();
        if ($campaign) {
            Delete::dispatch($campaign);
            DisabledBragi::dispatch($campaign);
            DeletedCampaignCleanupJob::dispatch($campaign);
            $this->info('Queued campaign #' . $campaignId . ' for deletion');
        } else {
            $this->info('Invalid campaign ID');
        }

        return 0;
    }
}
