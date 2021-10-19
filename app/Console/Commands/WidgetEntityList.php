<?php

namespace App\Console\Commands;

use App\Models\CampaignDashboardWidget;
use App\Observers\CampaignDashboardWidgetObserver;
use Illuminate\Console\Command;

class WidgetEntityList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'widgets:entity-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate unmentioned widgets to the recent type';

    /** @var int */
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
        /** @var CampaignDashboardWidget[] $widgets */
        $widgets = CampaignDashboardWidget::where('widget', CampaignDashboardWidget::WIDGET_UNMENTIONED)
            ->get();

        foreach ($widgets as $widget) {
            $widget->getEventDispatcher()->forget(CampaignDashboardWidgetObserver::class);


            $widget->widget = CampaignDashboardWidget::WIDGET_RECENT;
            $config = $widget->config;
            $config['adv_filter'] = 'unmentioned';
            $widget->config = $config;
            $widget->save();

            $this->count++;
        }

        $this->info('Migrated ' . $this->count . ' widgets.');
        return 0;
    }
}
