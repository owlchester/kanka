<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EntityEventController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'entity_event';
    protected $route = 'entity_event';

    protected $calendarService;

    /**
     * @var string
     */
    protected $model = \App\Models\EntityEvent::class;

    /**
     * CalendarController constructor.
     */
    public function __construct(CalendarService $calendarService)
    {
        parent::__construct();
        $this->calendarService = $calendarService;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('attribute', $entity->child);
        $entityEvent->delete();

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'events'])
            ->with('success', trans('calendars.event.destroy', ['name' => $entityEvent->calendar->name]));
    }
}
