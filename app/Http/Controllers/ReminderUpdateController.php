<?php

namespace App\Http\Controllers;

use App\Enums\EntityEventTypes;
use App\Http\Requests\UpdateCalendarEvent;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityEventType;
use App\Models\Post;
use App\Models\Reminder;
use App\Services\CalendarService;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Str;

class ReminderUpdateController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    protected string $view = 'entity_event';

    protected string $route = 'reminders';

    protected ?Entity $entity = null;

    protected ?Post $post = null;

    protected CalendarService $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        // parent::__construct();
        $this->calendarService = $calendarService;
    }

    public function edit(Campaign $campaign, Reminder $reminder)
    {
        $this->checkPermissions($reminder);
        $entity = $this->entity;
        $post = $this->post;
        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $calendar = $reminder->calendar;
        $next = request()->get('next', null);
        $from = request()->get('from', null);
        if (! empty($from)) {
            if ($from !== 'calendar') {
                $from = Calendar::find($from);
            }
        }

        return view('calendars.reminders.edit', compact(
            'campaign',
            'entity',
            'post',
            'reminder',
            'calendar',
            'name',
            'route',
            'parent',
            'next',
            'from'
        ));
    }

    public function update(UpdateCalendarEvent $request, Campaign $campaign, Reminder $reminder)
    {
        $this->checkPermissions($reminder);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if (request()->has('entity_id') && request()->get('entity_id') != $this->entity->id && is_null($this->post)) {
            $newEntity = Entity::findOrFail(request()->get('entity_id'));

            $this->authorize('reminders', $newEntity);
            $request->merge(['type_id' => null]);
        }

        if (! is_null($this->post)) {
            $request->merge(['type_id' => EntityEventTypes::CALENDAR_DATE->value]);
        }

        $routeOptions = ['campaign' => $campaign, 'entity' => $reminder->calendar->entity, 'year' => request()->post('year')];
        $reminder->update($request->all());

        if (request()->has('layout')) {
            $routeOptions['layout'] = request()->get('layout');
        }
        if (request()->get('layout', $reminder->calendar->defaultLayout()) !== 'year') {
            $routeOptions['month'] = request()->post('month');
        }

        $next = request()->post('next', '0');
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', [$campaign, $reminder->calendar])
                ->with('success', __('calendars.event.edit.success'));
        } elseif ($next == 'entity.reminders') {
            return redirect()
                ->route('entities.reminders.index', [$campaign, $this->entity])
                ->with('success', __('calendars.event.edit.success'));
        } elseif (Str::startsWith($next, 'calendar.')) {
            $id = Str::after($next, 'calendar.');
            $routeOptions['calendar'] = $id;
        }

        return redirect()->route('entities.show', $routeOptions)
            ->with('success', __('calendars.event.edit.success'));
    }

    public function destroy(Campaign $campaign, Reminder $reminder)
    {
        $this->checkPermissions($reminder);

        $reminder->delete();
        $success = __('calendars.event.destroy', ['name' => $reminder->calendar->name]);

        $next = request()->post('next', '0');
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', [$campaign, $reminder->calendar])
                ->with('success', $success);
        } elseif ($next == 'entity.reminders') {
            return redirect()
                ->route('entities.reminders.index', [$campaign, $this->entity])
                ->with('success', $success);
        } elseif (Str::startsWith($next, 'calendar.')) {
            return redirect()
                ->route('entities.show', [$campaign, $reminder->calendar->entity])
                ->with('success', $success);
        }

        return redirect()
            ->route('entities.reminders.index', [$campaign, $this->entity])
            ->with('success', $success);
    }

    private function checkPermissions(Reminder $reminder)
    {
        if ($reminder->remindable instanceof Post) {
            $this->authorize('reminders', $reminder->remindable->entity);
            $this->entity = $reminder->remindable->entity;
            $this->post = $reminder->remindable;
        } else {
            $this->authorize('reminders', $reminder->remindable);
            $this->entity = $reminder->remindable;
            $this->post = null;
        }
    }
}
