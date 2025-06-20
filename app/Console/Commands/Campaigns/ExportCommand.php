<?php

namespace App\Console\Commands\Campaigns;

use App\Models\Campaign;
use App\Models\User;
use App\Services\Campaign\ExportService;
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

    public function __construct(protected ExportService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(Carbon::now());

        $campaignID = $this->argument('campaign');
        $campaign = Campaign::find($campaignID);
        $user = User::find(1);

        $this->service
            ->campaign($campaign)
            ->user($user)
            ->queue();

        $this->info(Carbon::now() . ': Queues campaign #' . $campaign->id . ' export.');
    }
}
