<?php /** @var \App\Models\Calendar $model */?>
@if (empty($day))
    <td class=""></td>
@else
    <td class="{{ $day['isToday'] ? 'today' : null}} text-center" data-date="{{ \Illuminate\Support\Arr::get($day, 'date', null) }}">
        @if ($day['day'])
            <h5 class="pull-left{{ $day['isToday'] ? " label label-primary" : null}}">
                <span class="day-number">{{ $day['day'] }}</span>
                <span class="julian-number">{{ $day['julian'] }}</span></h5>
            @if ($canEdit)
                <div class="dropdown pull-right">
                    <a class="dropdown-toggle btn btn-xs btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right">
                        <i class="fa-solid fa-ellipsis-h" data-tree="escape"></i>
                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                    </a>
@php
    $routeOptions = [
    $model, 'date' => $day['date']
];
if ($renderer->isYearlyLayout() && !$model->yearlyLayout()) {
    $routeOptions['layout'] = 'year';
} elseif (!$renderer->isYearlyLayout() && $model->yearlyLayout()) {
    $routeOptions['layout'] = 'month';
}
@endphp
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <a href="{{ route('calendars.event.create', $routeOptions) }}" data-toggle="ajax-modal"
                               data-target="#entity-modal" data-url="{{ route('calendars.event.create', $routeOptions) }}"
                               class="" data-date="{{ $day['date'] }}">
                                <i class="fa-solid fa-plus"></i> {{ __('calendars.actions.add_reminder') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('calendars.calendar_weather.create', $routeOptions) }}" data-toggle="ajax-modal"
                               data-target="#entity-modal" data-url="{{ route('calendars.calendar_weather.create', $routeOptions) }}"
                               class="" data-date="{{ $day['date'] }}">
                                <i class="fa-solid fa-snowflake"></i> {{ __('calendars.actions.' .  (!empty($day['weather']) ? 'update_weather' : 'add_weather')) }}
                            </a>
                        </li>

                        @if (!\Illuminate\Support\Arr::get($day, 'isToday', false))
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('calendars.today', $routeOptions) }}"
                                   class="" data-date="{{ $day['date'] }}">
                                    <i class="fa-solid fa-check"></i> {{ __('calendars.actions.set_today') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
            @if ($day['day'] == 1 && !empty($showMonth))
            <span class="hidden-xs hidden-sm">{{ $day['month'] }}</span>
            @endif
            @if (!empty($day['moons']))
                @foreach ($day['moons'] as $moon)
                    <i class="moon {{ $moon['class'] }} text-{{ \Illuminate\Support\Arr::get($moon, 'colour', 'grey') }}" title="{{ __('calendars.show.moon_' . $moon['type'], ['moon' => $moon['name']]) }}" data-toggle="tooltip"></i>
                @endforeach
            @endif
            @if (!empty($day['season']))
                <div class="label label-default calendar-season" title="{{ __('calendars.parameters.seasons.name') }}">{{ $day['season'] }}</div>
            @endif

            <p class="text-left">
                @if (!empty($day['weather']))
                    <div class="weather weather-{{ $day['weather']->weather }}" data-html="true" data-toggle="tooltip" title="{!! $day['weather']->tooltip() !!}">
                        <i class="fa-solid fa-{{ $day['weather']->weather }}"></i>
                        {{ $day['weather']->weatherName() }}
                    </div>
                @endif
                @if (!empty($day['events']))
                    @foreach ($day['events'] as $event)
                        <?php /** @var \App\Models\EntityEvent $event */?>
                        <div class="label calendar-event-block {{ $event->getLabelColour() }}" style="background-color: {{ $event->getLabelBackgroundColour() }};"
                            @if ($canEdit)
@php unset($routeOptions[0]); unset($routeOptions['date']); @endphp
                                data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_events.edit', array_merge(($event->calendar_id !== $model->id ? [$event->entity->id, $event->id, 'from' => $model->calendar_id, 'next' => 'calendar.' . $model->id] : [$event->entity->id, $event->id]), $routeOptions)) }}"
                            @else
                                data-url="{{ $event->entity->url() }}"
                            @endif
                            >
                            @if (!empty($event->entity->child->image))
                            <a href="{{ $event->entity->url() }}" class="hidden-xs hidden-sm entity-image" style="background-image: url('{{ $event->entity->child->thumbnail() }}');"></a>
                            @endif
                            <span data-toggle="tooltip-ajax" data-id="{{ $event->entity->id }}" data-url="{{ route('entities.tooltip', $event->entity->id) }}" class="reminder-entity">
                                {{ $event->entity->name }}
                                @if (isset($renderer->getEventStartDates()[$event->id]) && in_array($day['date'], $renderer->getEventStartDates()[$event->id]))
                                    {{ __('calendars.events.start')}}
                                @elseif (isset($renderer->getEventEndDates()[$event->id]) && in_array($day['date'], $renderer->getEventEndDates()[$event->id]))
                                    {{ __('calendars.events.end')}}
                                @endif
                            </span>
                            {!! $event->getLabel() !!}
                        </div>
                    @endforeach
                @endif
            </p>
        @endif
    </td>
@endif
