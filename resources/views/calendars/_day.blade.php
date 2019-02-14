@if (empty($day))
    <td class=""></td>
@else
    <td class="{{ $day['isToday'] ? 'today' : null}} text-center">
        @if ($day['day'])
            <h5 class="pull-left{{ $day['isToday'] ? " label label-primary" : null}}">{{ $day['day'] }}</h5>
            @if ($canEdit)
            <a href="{{ route('calendars.event.create', [$model, 'date' => $day['date']]) }}" data-toggle="ajax-modal"
               data-target="#entity-modal" data-url="{{ route('calendars.event.create', [$model, 'date' => $day['date']]) }}"
               class="add btn btn-xs btn-default pull-right" data-date="{{ $day['date'] }}">
                <i class="fa fa-plus"></i>
            </a>
            @endif
            @if ($day['day'] == 1 && !empty($showMonth))
            <span class="hidden-xs hidden-sm">{{ $day['month'] }}</span>
            @endif
            @if (!empty($day['moons']))
                @foreach ($day['moons'] as $moon)
                    <i class="ra ra-moon-sun" title="{{ __('calendars.show.moon_full_moon', ['moon' => $moon]) }}" data-toggle="tooltip"></i>
                @endforeach
            @endif
            @if (!empty($day['season']))
                <div class="label label-default calendar-season" title="{{ __('calendars.parameters.seasons.name') }}">{{ $day['season'] }}</div>
            @endif
            <p class="text-left">
                @if (!empty($day['events']))
                    @foreach ($day['events'] as $event)
                        <?php /** @var \App\Models\EntityEvent $event */?>
                        <div class="label calendar-event-block {{ $event->getLabelColour() }}"
                            @if ($canEdit)
                                data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_events.edit', [$event->entity->id, $event->id]) }}"
                            @else
                                data-url="{{ $event->entity->url() }}"
                            @endif
                            >
                            @if (!empty($event->entity->child->image))
                            <a href="{{ $event->entity->url() }}" class="entity-image" style="background-image: url('{{ $event->entity->child->getImageUrl(true) }}');"></a>
                            @endif
                            <span data-toggle="tooltip" title="{{ $event->entity->tooltip() }}">{{ $event->entity->name }}</span>
                            {!! $event->getLabel() !!}
                        </div>
                    @endforeach
                @endif
            </p>
        @endif
    </td>
@endif