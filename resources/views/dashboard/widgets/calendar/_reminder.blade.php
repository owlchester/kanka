<li data-ago="{{ isset($future) ? $reminder->inDays() : $reminder->daysAgo() }}" class="flex gap-2">
    <div class="grow">
        {{ link_to($reminder->entity->url(), $reminder->entity->name) }}

        @if (app()->environment('local'))
            @if (isset($future))
                <span class="text-xs">({{ $reminder->date() }}, in {{ $reminder->inDays() }} days)</span>
            @else
                <span class="text-xs">({{ $reminder->date() }}, {{ $reminder->daysAgo() }} days ago)</span>
            @endif
        @endif
    </div>

    <div class="flex gap-1 items-center">
        @if (!empty($reminder->comment))
            <i class="fa-solid fa-comment" data-title="{{ $reminder->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
        @endif
        @if ($reminder->is_recurring)
            <i class="fa-solid fa-arrows-rotate" data-title="{{ __('calendars.fields.is_recurring') }}" data-toggle="tooltip"></i>
        @endif
        <i class="fa-solid fa-calendar" data-title="{{ $reminder->readableDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
    </div>
</li>
