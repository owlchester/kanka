<li data-ago="{{ isset($future) ? $reminder->inDays() : $reminder->daysAgo() }}" class="flex gap-2">
    <div class="grow">
        <a href="{{ $reminder->remindable->url() }}">{!! $reminder->remindable->name !!}</a>

        @if (config('app.debug'))
            @if (isset($future))
                <span class="text-xs">({{ $reminder->date() }}, in {{ $reminder->inDays() }} days)</span>
            @else
                <span class="text-xs">({{ $reminder->date() }}, {{ $reminder->daysAgo() }} days ago)</span>
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
