<?php

namespace App\Console\Commands\Campaigns;

use App\Models\Campaign;
use App\Services\Campaign\ExportService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:export {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export a campaign';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(Carbon::now());

        /** @var ExportService $service */
        $service = app()->make(ExportService::class);

        $campaignID = $this->argument('campaign');
        $campaign = Campaign::find($campaignID);
        $user = User::find(1);

        $service
            ->campaign($campaign)
            ->user($user)
            ->queue();

        $this->info(Carbon::now() . ': Queues campaign #' . $campaign->id . ' export.');
    }
}
