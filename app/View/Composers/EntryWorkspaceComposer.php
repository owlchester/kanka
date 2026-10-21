<?php

namespace App\View\Composers;

use App\Models\Calendar;
use App\Models\Entity;
use App\Services\Entity\EntryDateService;
use Illuminate\View\View;

class EntryWorkspaceComposer
{
    public function __construct(private EntryDateService $dates) {}

    public function compose(View $view): void
    {
        $data = $view->getData();
        $campaign = $data['campaign'];
        $entityType = $data['entityType'];
        $creating = $data['creating'] ?? false;
        $entity = $creating ? null : ($data['entity'] ?? null);
        $dateEntity = $entity;
        $source = $data['source'] ?? null;
        if ($creating && $source instanceof Entity && $source->type_id === $entityType->id && auth()->user()->can('view', $source)) {
            $dateEntity = $source;
        }
        $calendars = collect();
        $rows = [];
        if ($campaign->enabled('calendars') && EntryDateService::types($entityType->id)) {
            $calendars = Calendar::where('campaign_id', $campaign->id)->with('entity')->get()
                ->filter(fn (Calendar $calendar) => $calendar->entity && auth()->user()->can('update', $calendar->entity));
            foreach (EntryDateService::types($entityType->id) as $key => $type) {
                $editable = ! $dateEntity || $this->dates->editableReminder($dateEntity, $type);
                $reminder = $editable && $dateEntity ? $dateEntity->reminders()->where('type_id', $type)->first() : null;
                $rows[$key] = [
                    'editable' => $editable,
                    'existing' => ! $creating && $reminder !== null,
                    'filled' => $reminder !== null,
                    'calendar_id' => old("entry_dates.$key.calendar_id", $reminder?->calendar_id),
                    'year' => old("entry_dates.$key.year", $reminder?->year),
                    'month' => old("entry_dates.$key.month", $reminder?->month),
                    'day' => old("entry_dates.$key.day", $reminder?->day),
                ];
            }
        }
        $options = $calendars->mapWithKeys(fn (Calendar $calendar) => [$calendar->id => [
            'months' => array_column($calendar->months(), 'name'),
            'current' => empty($calendar->date) ? null : [
                'year' => $calendar->currentYear(),
                'month' => $calendar->currentMonth(),
                'day' => $calendar->currentDay(),
            ],
        ]]);
        $view->with('dateCalendars', $calendars)->with('dateRows', $rows)->with('dateCalendarOptions', $options);
    }
}
