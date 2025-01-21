<?php

namespace App\Http\Controllers\Calendars\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Models\Campaign;
use App\Models\Calendar;
use App\Models\EntityEvent;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;

class EntityEventController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    public function index(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar->entity);
        $action = $request->get('action');
        $models = $request->get('model');
        if (!in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->campaign($campaign)->bulkBatch(route('calendars.entity-events.bulk', [
                'campaign' => $campaign, 'calendar' => $calendar]), '_calendar-event', $models, $calendar);
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $count = $this->campaign($campaign)->bulkProcess($request, EntityEvent::class);

        return redirect()
            ->route('calendars.events', [$campaign, 'calendar' => $calendar])
            ->with('success', trans_choice('calendars.events.bulks.' . $action, $count, ['count' => $count]))
        ;
    }
}
