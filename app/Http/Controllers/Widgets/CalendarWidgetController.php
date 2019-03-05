<?php

namespace App\Http\Controllers\Widgets;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\CampaignDashboardWidget;

class CalendarWidgetController extends Controller
{
    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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

    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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
