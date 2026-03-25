<?php

namespace App\Http\Controllers\Calendars;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalendarEra;
use App\Models\Calendar;
use App\Models\CalendarEra;
use App\Models\Campaign;
use App\Renderers\Layouts\Calendar\Era;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class EraController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    /** @var string[] Form fields passed on to the model */
    protected array $fields = [
        'name',
        'description',
        'colour',
        'visibility_id',
        'start_day',
        'start_month',
        'start_year',
        'end_day',
        'end_month',
        'end_year',
        'show_era_dates',
    ];

    public function index(Campaign $campaign, Calendar $calendar)
    {
        $this->campaign($campaign)->authEntityView($calendar->entity);

        $options = [$campaign, 'calendar' => $calendar];
        Datagrid::layout(Era::class)
            ->route('calendars.calendar_eras.index', $options)
            ->permissions(! (auth()->check() && auth()->user()->can('update', $calendar)));

        // @phpstan-ignore-next-line
        $this->rows = $calendar->calendarEras()
            ->sort(request()->only(['o', 'k']), ['start_year' => 'asc'])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('calendars.eras', $calendar);
    }

    public function create(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar->entity);

        return view('calendars.eras.create', compact(
            'campaign',
            'calendar',
        ));
    }

    public function store(StoreCalendarEra $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar->entity);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only($this->fields);
        $data['calendar_id'] = $calendar->id;
        $data['show_era_dates'] = $request->boolean('show_era_dates');
        $new = CalendarEra::create($data);

        return redirect()
            ->route('calendars.calendar_eras.index', [$campaign, $calendar])
            ->withSuccess(__('calendars/eras.create.success', ['name' => $new->name]));
    }

    public function show(Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        return redirect()->route('calendars.calendar_eras.index', [$campaign, $calendar]);
    }

    public function edit(Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        $this->authorize('update', $calendar->entity);

        $model = $calendarEra;

        return view('calendars.eras.edit', compact(
            'campaign',
            'calendar',
            'model',
        ));
    }

    public function update(StoreCalendarEra $request, Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        $this->authorize('update', $calendar->entity);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only($this->fields);
        $data['show_era_dates'] = $request->boolean('show_era_dates');
        $calendarEra->update($data);

        return redirect()
            ->route('calendars.calendar_eras.index', [$campaign, $calendar])
            ->withSuccess(__('calendars/eras.edit.success', ['name' => $calendarEra->name]));
    }

    public function destroy(Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        $this->authorize('update', $calendar->entity);

        $calendarEra->delete();

        return redirect()
            ->route('calendars.calendar_eras.index', [$campaign, $calendar])
            ->withSuccess(__('calendars/eras.delete.success', ['name' => $calendarEra->name]));
    }
}
