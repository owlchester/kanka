<?php

namespace App\Http\Controllers\Widgets;

use App\Enums\Widget;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Services\Calendars\AdvancerService;
use App\Services\Calendars\ReminderService;

class CalendarWidgetController extends Controller
{
    protected AdvancerService $service;

    protected ReminderService $reminderService;

    public function __construct(AdvancerService $advancerService, ReminderService $reminderService)
    {
        $this->service = $advancerService;
        $this->reminderService = $reminderService;
    }

    public function add(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false,
            ]);
        }

        /** @var Calendar $calendar */
        $calendar = $campaignDashboardWidget->entity->child;
        $this->service->calendar($calendar)->advance();

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget)
            ->with('calendar', $calendar)
            ->with('campaign', $campaign);
    }

    public function sub(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false,
            ]);
        }

        /** @var Calendar $calendar */
        $calendar = $campaignDashboardWidget->entity->child;
        $this->service->calendar($calendar)->retreat();

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget)
            ->with('calendar', $calendar)
            ->with('campaign', $campaign);
    }

    public function render(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false,
            ]);
        }

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget)
            ->with('campaign', $campaign);
    }
}
