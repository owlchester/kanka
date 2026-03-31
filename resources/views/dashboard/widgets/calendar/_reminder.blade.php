<?php /** @var \App\Models\Reminder $reminder */?>
<?php
if ($reminder->remindable instanceof \App\Models\Post && !$reminder->remindable->entity) {
    return;
}
?>
<li data-ago="{{ isset($future) ? $reminder->inDays() : $reminder->daysAgo() }}" class="flex gap-2 justify-between overflow-hidden">
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
            @if (isset($future))
                <span class="text-xs text-neutral-content">({{ $reminder->date() }}, in {{ $reminder->inDays() }} days)</span>
            @else
                <span class="text-xs text-neutral-content">({{ $reminder->date() }}, {{ $reminder->daysAgo() }} days ago)</span>
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
        <x-icon class="fa-regular fa-calendar" title="{{ $reminder->readableDate() }}" tooltip />
    </div>
</li>
