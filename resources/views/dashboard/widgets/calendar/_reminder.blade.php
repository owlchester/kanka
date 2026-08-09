<?php
/** @var \App\ValueObjects\Calendars\ReminderOccurrence $reminderOccurrence */
$reminder = $reminderOccurrence->reminder;
$occurrence = $reminderOccurrence->occurrence;
if ($reminder->remindable instanceof \App\Models\Post && ! $reminder->remindable->entity) {
    return;
}
$occurrenceDate = $calendar->niceDate((string) $occurrence->start);
?>
<li data-ago="{{ $reminderOccurrence->distance }}" data-state="{{ $reminderOccurrence->state }}" class="flex gap-2 justify-between overflow-hidden">
    <div class="truncate">
        @if ($reminder->isPost())
            <x-entity-link :entity="$reminder->remindable->entity" :campaign="$campaign">
                {!! $reminder->remindable->name !!} ({!! $reminder->remindable->entity->name !!})
            </x-entity-link>
        @else
            <x-entity-link :entity="$reminder->remindable" :campaign="$campaign">
                {!! $reminder->remindable->name !!}
            </x-entity-link>
        @endif
        @if (config('app.debug'))
            @if ($reminderOccurrence->isActive())
                <span class="text-xs text-neutral-content">({{ $occurrence->start->key() }}, {{ __('dashboard.widgets.calendar.happening_now') }})</span>
            @elseif ($reminderOccurrence->state === 'upcoming')
                <span class="text-xs text-neutral-content">({{ $occurrence->start->key() }}, {{ trans_choice('dashboard.widgets.calendar.in_days', $reminderOccurrence->distance, ['count' => $reminderOccurrence->distance]) }})</span>
            @else
                <span class="text-xs text-neutral-content">({{ $occurrence->start->key() }}, {{ trans_choice('dashboard.widgets.calendar.days_ago', $reminderOccurrence->distance, ['count' => $reminderOccurrence->distance]) }})</span>
            @endif
        @endif
    </div>

    <div class="flex gap-1 items-center">
        @if (!empty($reminder->comment))
            <x-icon class="fa-regular fa-comment" tooltip title="{{ $reminder->comment }}" />
        @endif
        @if ($reminder->is_recurring)
            <x-icon class="fa-regular fa-arrows-rotate" title="{{ __('calendars.fields.is_recurring') }}" tooltip />
        @endif
        <x-icon class="fa-regular fa-calendar" title="{{ $occurrenceDate }}" tooltip />
    </div>
</li>
