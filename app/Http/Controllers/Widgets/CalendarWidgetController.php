<?php

namespace App\Http\Controllers\Widgets;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Enums\Widget;

class CalendarWidgetController extends Controller
{
    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false
            ]);
        }

        /** @var Calendar $calendar */
        $calendar = $campaignDashboardWidget->entity->child;
        $calendar->addDay();

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget)
            ->with('campaign', $campaign);
    }

    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function sub(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false
            ]);
        }

        /** @var Calendar $calendar */
        $calendar = $campaignDashboardWidget->entity->child;
        $calendar->subDay();

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget)
            ->with('campaign', $campaign);
    }

    /**
     * Render a calendar widget
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function render(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        if ($campaignDashboardWidget->widget != Widget::Calendar) {
            return response()->json([
                'success' => false
            ]);
        }

        return view('dashboard.widgets.calendar.body')
            ->with('widget', $campaignDashboardWidget)
            ->with('campaign', $campaign);
    }
}
