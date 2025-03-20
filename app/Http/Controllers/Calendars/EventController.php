<?php

namespace App\Http\Controllers\Calendars;

use App\Exceptions\TranslatableException;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\ValidateReminderLength;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Services\CalendarService;
use App\Services\LengthValidatorService;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;
use Exception;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    protected CalendarService $service;

    protected LengthValidatorService $lengthValidatorService;

    public function __construct(CalendarService $calendarService, LengthValidatorService $lengthValidatorService)
    {
        $this->service = $calendarService;
        $this->lengthValidatorService = $lengthValidatorService;
    }

    public function index(Campaign $campaign, Calendar $calendar)
    {
        $this->campaign($campaign)->authEntityView($calendar->entity);

        $options = [$campaign, 'calendar' => $calendar];
        $after = $before = false;
        if (request()->has('before_id')) {
            $options['before_id'] = 1;
            $before = true;
        } elseif (request()->has('after_id')) {
            $options['after_id'] = 1;
            $after = true;
        }
        Datagrid::layout(\App\Renderers\Layouts\Calendar\Reminder::class)
            ->route('calendars.events', $options)
            ->permissions(! (auth()->check() && auth()->user()->can('update', $calendar)));

        $rows = $calendar->calendarEvents();
        if ($after) {
            $rows->after($calendar);
        } elseif ($before) {
            $rows->before($calendar);
        }

        $this->rows = $rows
            ->with(['entity', 'calendar', 'entity.image', 'entity.entityType'])
            ->has('entity')
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('calendars.events', $calendar);
    }

    public function create(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar->entity);

        $date = request()->get('date', '1-1-1');
        [$year, $month, $day] = explode('-', $date);
        if (Str::startsWith($date, '-')) {
            [$year, $month, $day] = explode('-', mb_trim($date, '-'));
            $year = "-{$year}";
        }

        return view('calendars.events.create', compact(
            'campaign',
            'calendar',
            'day',
            'month',
            'year',
        ));
    }

    public function store(AddCalendarEvent $request, Campaign $campaign, Calendar $calendar)
    {
        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $routeOptions = [$campaign, $calendar->entity, 'year' => $request->post('year')];
        if ($request->has('layout')) {
            $routeOptions['layout'] = $request->get('layout');
        } else {
            $routeOptions['month'] = $request->post('month');
        }

        // We need to handle negative year dates (start with -)
        try {
            $link = $this->service
                ->user($request->user())
                ->campaign($campaign)
                ->calendar($calendar)
                ->addEvent($request->all());

            return redirect()->route('entities.show', $routeOptions)
                ->with('success', __('calendars.event.success', ['event' => $link->entity->name]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('entities.show', $routeOptions)
                ->with('error', __('crud.bulk.errors.general', ['hint' => $e->getTranslatedMessage()]));
        } catch (Exception $e) {
            return redirect()->route('entities.show', $routeOptions);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function eventLength(Campaign $campaign, Calendar $calendar, ValidateReminderLength $request)
    {
        $this->authorize('view', $calendar->entity);

        return response()->json($this->lengthValidatorService->validateLength($calendar, $request));
    }
}
