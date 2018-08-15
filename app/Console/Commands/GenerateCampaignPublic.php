<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignRole;
use Illuminate\Console\Command;

class GenerateCampaignPublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the campaign public roles';

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
     * @return mixed
     */
    public function handle()
    {

        $count = 0;
        foreach (Campaign::get() as $campaign) {
            $count++;
            $publicRole = CampaignRole::create([
                'campaign_id' => $campaign->id,
                'is_public' => true,
                'name' => 'Public',
            ]);
        }

        $this->info("Created $count campaign roles.");

        return true;
    }
}
