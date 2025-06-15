<?php

namespace App\Http\Controllers\Entity;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCalendarEvent;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Reminder;
use App\Services\CalendarService;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

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

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $campaign->enabled('calendars')) {
            return redirect()->route('entities.show', [$campaign, $entity])->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#calendars']) . '">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }

        $options = ['campaign' => $campaign, 'entity' => $entity];
        Datagrid::layout(\App\Renderers\Layouts\Entity\Reminder::class)
            ->route('entities.reminders.index', $options);

        $this->rows = $entity
            ->reminders()
            ->has('calendar')
            ->has('calendar.entity')
            ->with(['calendar', 'calendar.entity', 'remindable'])
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return view('entities.pages.reminders.index')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('rows', $this->rows);
    }

    public function show(Campaign $campaign, Entity $entity, Reminder $reminder)
    {
        return redirect()
            ->route('entities.reminders.index', [$campaign, $entity]);
    }

    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('reminders', $entity);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $next = request()->get('next', null);
        $calendars = Calendar::get();

        return view('calendars.reminders.create_from_entity', compact(
            'campaign',
            'entity',
            'name',
            'route',
            'parent',
            'next',
            'entity',
            'calendars',
        ));
    }

    public function store(AddCalendarEvent $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('reminders', $entity);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Since reminders are polymorphic, we need to attach them to the proper model
        $entity = Entity::findOrFail($request->get('entity_id'));
        $data = [
            'calendar_id' => $request->get('calendar_id'),
            'day' => $request->get('day'),
            'month' => $request->get('month'),
            'year' => $request->get('year'),
            'comment' => $request->get('comment'),
            'length' => $request->get('length'),
            'colour' => $request->get('colour'),
            'recurring_periodicity' => $request->get('recurring_periodicity'),
            'recurring_until' => $request->get('recurring_until'),
            'visibility_id' => $request->get('visibility_id'),
            'type_id' => $request->get('type_id'),
        ];
        $entity->reminders()->create($data);

        //        $reminder = new Reminder($request->all());
        //        $reminder->entity_id = $entity->id;
        //        $reminder->save();

        $next = request()->post('next', '0');
        if ($next == 'entity.events') {
            return redirect()
                ->route('entities.reminders.index', [$campaign, $entity])
                ->with('success', __('calendars.event.create.success'));
        }

        return redirect()
            ->route('entities.reminders.index', [$campaign, $entity])
            ->with('success', __('calendars.event.create.success'));
    }
}
