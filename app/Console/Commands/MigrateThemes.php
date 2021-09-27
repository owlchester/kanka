<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignStyle;
use Illuminate\Console\Command;

class MigrateThemes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:themes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate campaign.css to campaign_styles';

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
        Campaign::whereNotNull('css')->chunk(500, function ($campaigns) {
            /** @var Campaign $campaign */
            foreach ($campaigns as $campaign) {
                $style = new CampaignStyle();
                $style->campaign_id = $campaign->id;
                $style->content = $campaign->css;
                $style->is_enabled = true;
                $style->name = 'Campaign style';
                $style->save();
                $this->count ++;
            }
        });

        $this->info('Moved ' . $this->count . ' campaign styles');
        return 0;
    }
}
