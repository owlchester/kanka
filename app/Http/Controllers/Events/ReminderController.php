<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCalendarEvent;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;
use App\Models\Reminder;
use App\Services\CalendarService;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class ReminderController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    protected string $view = 'entity_event';

    protected string $route = 'reminders';

    protected CalendarService $calendarService;

    protected string $model = Reminder::class;

    public function __construct(CalendarService $calendarService)
    {
        // parent::__construct();
        $this->calendarService = $calendarService;
    }

    public function edit(Campaign $campaign, Reminder $reminder)
    {
        if ($reminder->remindable instanceof Post) {
            $this->authorize('reminders', $reminder->remindable->entity);
            $entity  = $reminder->remindable->entity;
            $post = $reminder->remindable;
        } else {
            $this->authorize('reminders', $reminder->remindable);
            $entity  = $reminder->remindable;
            $post = null;
        }

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
        if ($reminder->remindable instanceof Post) {
            $this->authorize('reminders', $reminder->remindable->entity);
            $entity  = $reminder->remindable->entity;
            $post = $reminder->remindable;
        } else {
            $this->authorize('reminders', $reminder->remindable);
            $entity  = $reminder->remindable;
            $post = null;
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if (request()->has('entity_id') && request()->get('entity_id') != $entity->id && isNull($post)) {
            $newEntity = Entity::findOrFail(request()->get('entity_id'));

            $this->authorize('reminders', $newEntity);
            $request->merge(['type_id' => null]);
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
                ->route('entities.reminders.index', [$campaign, $entity])
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
        if ($reminder->remindable instanceof Post) {
            $this->authorize('reminders', $reminder->remindable->entity);
            $entity  = $reminder->remindable->entity;
            $post = $reminder->remindable;
        } else {
            $this->authorize('reminders', $reminder->remindable);
            $entity  = $reminder->remindable;
            $post = null;
        }
        $reminder->delete();
        $success = __('calendars.event.destroy', ['name' => $reminder->calendar->name]);

        $next = request()->post('next', '0');
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', [$campaign, $reminder->calendar])
                ->with('success', $success);
        } elseif ($next == 'entity.reminders') {
            return redirect()
                ->route('entities.reminders.index', [$campaign, $entity])
                ->with('success', $success);
        } elseif (Str::startsWith($next, 'calendar.')) {
            return redirect()
                ->route('entities.show', [$campaign, $reminder->calendar->entity])
                ->with('success', $success);
        }

        return redirect()
            ->route('entities.reminders.index', [$campaign, $entity])
            ->with('success', $success);
    }
}
