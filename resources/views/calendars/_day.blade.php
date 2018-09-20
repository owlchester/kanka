<td class="{{ $day['isToday'] ? 'today' : null}} text-center">
    @if ($day['day'])
        <h5 class="pull-left{{ $day['isToday'] ? "label label-primary" : null}}">{{ $day['day'] }}</h5>
        @if (Auth::check() && Auth::user()->can('update', $model))
            <a href="#" class="add btn btn-xs btn-default pull-right" data-date="{{ $day['date'] }}">
                <i class="fa fa-plus"></i>
            </a>
        @endif
        @if ($day['day'] == 1 && !empty($showMonth))
            <span class="hidden-xs hidden-sm">{{ $day['month'] }}</span>
        @endif
        <p class="text-left">
            @if (!empty($day['events']))
                @foreach ($day['events'] as $event)
                    <a href="{{ route($event->entity->pluralType() . '.show', $event->entity->entity_id) }}" data-toggle="tooltip" title="{{ $event->entity->tooltip() }}">{{ $event->entity->name }}</a>
                    @if ($event->is_recurring)
                        &nbsp;<i class="fa fa-refresh pull-right" data-toggle="tooltip" title="{{ trans('calendars.fields.is_recurring') }}"></i>
                    @endif
                    @if ($event->comment)
                        &nbsp;<i class="fa fa-comment pull-right margin-r-5" data-toggle="tooltip" title="{{ $event->comment }}"></i>
                    @endif
                    <br />
                @endforeach
            @endif
        </p>
    @endif
</td>