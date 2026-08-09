<?php

namespace App\Http\Controllers\Widgets;

use App\Enums\Widget;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Services\Calendars\AdvancerService;
use App\Services\Calendars\CalendarWidgetStateFactory;

class CalendarWidgetController extends Controller
{
    protected AdvancerService $service;

    public function __construct(
        AdvancerService $advancerService,
        protected CalendarWidgetStateFactory $stateFactory,
    ) {
        $this->service = $advancerService;
    }

    public function add(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false,
            ]);
        }

        $entity = $campaignDashboardWidget->entity;
        $this->authorize('update', $entity);
        abort_unless($entity->child instanceof Calendar, 404);
        $calendar = $entity->child;
        $this->service->calendar($calendar)->advance();

        return $this->body($campaign, $campaignDashboardWidget, $calendar);
    }

    public function sub(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false,
            ]);
        }

        $entity = $campaignDashboardWidget->entity;
        $this->authorize('update', $entity);
        abort_unless($entity->child instanceof Calendar, 404);
        $calendar = $entity->child;
        $this->service->calendar($calendar)->retreat();

        return $this->body($campaign, $campaignDashboardWidget, $calendar);
    }

    public function render(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false,
            ]);
        }

        $entity = $campaignDashboardWidget->entity;
        abort_unless($entity->child instanceof Calendar, 404);

        return $this->body($campaign, $campaignDashboardWidget, $entity->child);
    }

    private function body(Campaign $campaign, CampaignDashboardWidget $widget, Calendar $calendar)
    {
        return view('dashboard.widgets.calendar.body', [
            'campaign' => $campaign,
            'widget' => $widget,
            'calendar' => $calendar,
            'state' => $this->stateFactory->make($calendar),
        ]);
    }
}
