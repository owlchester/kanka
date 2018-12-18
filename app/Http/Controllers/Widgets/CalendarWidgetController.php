<?php

namespace App\Http\Controllers\Widgets;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\CampaignDashboardWidget;

class CalendarWidgetController extends Controller
{
    public function add(CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != CampaignDashboardWidget::WIDGET_CALENDAR) {
            return response()->json([
                'success' => false
            ]);
        }

        /** @var Calendar $calendar */
        $calendar = $campaignDashboardWidget->entity->child;
        $calendar->addDay();

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget);
    }


    public function sub(CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != CampaignDashboardWidget::WIDGET_CALENDAR) {
            return response()->json([
                'success' => false
            ]);
        }

        /** @var Calendar $calendar */
        $calendar = $campaignDashboardWidget->entity->child;
        $calendar->subDay();

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget);
    }
}