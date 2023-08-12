<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\UpdateCalendarEvent;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Services\CalendarService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Str;

class ReminderController extends Controller
{
    use GuestAuthTrait;

    /**
     * @var string
     */
    protected string $view = 'entity_event';
    protected string $route = 'entity_event';

    protected CalendarService $calendarService;

    /**
     * @var string
     */
    protected $model = \App\Models\EntityEvent::class;

    /**
     * CalendarController constructor.
     */
    public function __construct(CalendarService $calendarService)
    {
        //parent::__construct();
        $this->calendarService = $calendarService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child, $entity->typeId());
        }
        $reminders = $entity
            ->events()
            ->has('calendar')
            ->has('calendar.entity')
            ->with(['calendar', 'calendar.entity', 'entity'])
            ->ordered(request()->get('order'), 'events/date')
            ->paginate();

        return view('entities.pages.reminders.index', compact(
            'campaign',
            'entity',
            'reminders'
        ));
    }

    /**
     * @param Entity $entity
     * @param EntityEvent $entityEvent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Campaign $campaign, Entity $entity, EntityEvent $entityEvent)
    {
        return redirect()
            ->route('entities.entity_events.index', [$campaign, $entity]);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $next = request()->get('next', null);

        return view('calendars.events.create_from_entity', compact(
            'campaign',
            'entity',
            'name',
            'route',
            'parent',
            'next',
            'entity'
        ));
    }

    /**
     */
    public function store(AddCalendarEvent $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $reminder = new EntityEvent($request->all());
        $reminder->entity_id = $entity->id;
        $reminder->save();

        $next = request()->post('next', '0');
        if ($next == 'entity.events') {
            return redirect()
                ->route('entities.entity_events.index', [$campaign, $entity])
                ->with('success', __('calendars.event.create.success'));
        }

        return redirect()
            ->route('entities.entity_events.index', [$campaign, $entity])
            ->with('success', __('calendars.event.create.success'));
    }

    /**
     */
    public function edit(Campaign $campaign, Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('update', $entityEvent->calendar);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $calendar = $entityEvent->calendar;
        $next = request()->get('next', null);
        $from = request()->get('from', null);
        if (!empty($from)) {
            $from = Calendar::find($from);
        }

        return view('calendars.events.edit', compact(
            'campaign',
            'entity',
            'entityEvent',
            'calendar',
            'name',
            'route',
            'parent',
            'next',
            'from'
        ));
    }

    /**
     */
    public function update(UpdateCalendarEvent $request, Campaign $campaign, Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('update', $entityEvent->calendar);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if (request()->has('entity_id') && request()->get('entity_id') != $entity->id) {
            $newEntity = Entity::findOrFail(request()->get('entity_id'));

            $this->authorize('update', $newEntity->child);
            $request->merge(['type_id' => null]);
        }
        $routeOptions = ['campaign' => $campaign, 'calendar' => $entityEvent->calendar->id, 'year' => request()->post('year')];
        $entityEvent->update($request->all());

        if (request()->has('layout')) {
            $routeOptions['layout'] = request()->get('layout');
        }
        if (request()->get('layout', $entityEvent->calendar->defaultLayout()) !== 'year') {
            $routeOptions['month'] = request()->post('month');
        }

        $next = request()->post('next', '0');
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', [$campaign, $entityEvent->calendar])
                ->with('success', __('calendars.event.edit.success'));
        } elseif ($next == 'entity.events') {
            return redirect()
                ->route('entities.entity_events.index', [$campaign, $entity])
                ->with('success', __('calendars.event.edit.success'));
        } elseif (Str::startsWith($next, 'calendar.')) {
            $id = Str::after($next, 'calendar.');
            $routeOptions['calendar'] = $id;
        }

        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', __('calendars.event.edit.success'));
    }

    /**
     */
    public function destroy(Campaign $campaign, Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('attribute', $entity->child);
        $entityEvent->delete();
        $success = __('calendars.event.destroy', ['name' => $entityEvent->calendar->name]);

        $next = request()->post('next', '0');
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', [$campaign, $entityEvent->calendar])
                ->with('success', $success);
        } elseif ($next == 'entity.events') {
            return redirect()
                ->route('entities.entity_events.index', [$campaign, $entity])
                ->with('success', $success);
        }

        // Redirect to the calendar if that's where we came from
        $previous = url()->previous();
        if (str_contains($previous, '/calendars/')) {
            return redirect()->route('calendars.show', [$campaign, $entityEvent->calendar_id])
                ->with('success', $success);
        }

        return redirect()
            ->route('entities.entity_events.index', [$campaign, $entity])
            ->with('success', $success);
    }
}
