<?php /**
 * @var \App\Models\Calendar $model
 * @var \App\Models\EntityEvent $event
 */?>
@if(empty($day))
    <td class="h-24"></td>
@else

    @php
        $routeOptions = [
            $campaign,
            $model,
            'date' => $day['date']
    ];
    if ($renderer->isYearlyLayout() && !$model->yearlyLayout()) {
        $routeOptions['layout'] = 'year';
    } elseif (!$renderer->isYearlyLayout() && $model->yearlyLayout()) {
        $routeOptions['layout'] = 'month';
    }
    @endphp

    <td class="h-24 text-center break-words align-top {{ $day['isToday'] ? 'today bg-base-200' : null }}" data-date="{{ \Illuminate\Support\Arr::get($day, 'date', null) }}">
        <div class="flex flex-col gap-1">
        @if ($day['day'])
            <div class="flex items-center items-stretch gap-1">
                <h5 class="m-0 {{ $day['isToday'] ? "badge badge-primary" : null}}">
                    <span class="day-number">{{ $day['day'] }}</span>
                    <span class="julian-number">{{ $day['julian'] }}</span>
                </h5>
                <div class="grow">
                @if ($day['day'] == 1 && !empty($showMonth))
                    <span class="hidden md:inline">{{ $day['month'] }}</span>
                @endif
                </div>
                @if ($canEdit)
                <div class="dropdown">
                    <a class="btn2 btn-xs" data-dropdown aria-expanded="false" data-placement="right">
                        <i class="fa-solid fa-ellipsis-h" data-tree="escape"></i>
                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                    </a>

                    <div class="dropdown-menu hidden" role="menu">
                        @php $data = ['toggle' => 'dialog', 'date' => $day['date'], 'target' => 'primary-dialog', 'url' => route('calendars.event.create', $routeOptions)]; @endphp
                        <x-dropdowns.item link="#" :data="$data" icon="plus">
                            {{ __('calendars.actions.add_reminder') }}
                        </x-dropdowns.item>

                        @php $data = ['toggle' => 'dialog', 'date' => $day['date'], 'target' => 'primary-dialog', 'url' => route('calendars.calendar_weather.create', $routeOptions)]; @endphp
                        <x-dropdowns.item link="#" :data="$data" icon="fa-solid fa-snowflake">
                            {{ __('calendars.actions.' .  (!empty($day['weather']) ? 'update_weather' : 'add_weather')) }}
                        </x-dropdowns.item>

                        @if (!\Illuminate\Support\Arr::get($day, 'isToday', false))
                            <hr class="m-0" />
                            @php $data = ['date' => $day['date']]; @endphp
                            <x-dropdowns.item :link="route('calendars.today', $routeOptions)" :data="$data" icon="check">
                                {{ __('calendars.actions.set_today') }}
                            </x-dropdowns.item>
                        @endif
                    </div>
                </div>
               @endif
            </div>
            @if (!empty($day['moons']))
                @foreach ($day['moons'] as $moon)
                    <i class="moon {{ $moon['class'] }} text-{{ \Illuminate\Support\Arr::get($moon, 'colour', 'grey') }}" data-title="{{ __('calendars.show.moon_' . $moon['type'], ['moon' => $moon['name']]) }}" data-toggle="tooltip"></i>
                @endforeach
            @endif
            @if (!empty($day['season']))
                <div class="badge calendar-season bg-season block w-full !text-xs" data-toggle="tooltip" data-title="{{ __('calendars.parameters.seasons.name') }}">
                    {{ $day['season'] }}
                </div>
            @endif

            @if (!empty($day['weather']))
                <div class="weather weather-{{ $day['weather']->weather }}" data-html="true" data-toggle="tooltip" data-title="{!! $day['weather']->tooltip() !!}">
                    <i class="fa-solid fa-{{ $day['weather']->weather }}" aria-hidden="true"></i>
                    {{ $day['weather']->weatherName() }}
                </div>
            @endif
            @if (!empty($day['events']))
                @foreach ($day['events'] as $event)
                    <div class="calendar-event-block rounded-sm text-left p-1 relative overflow-hidden cursor-pointer text-sm {{ $event->getLabelColour() }}" style="background-color: {{ $event->getLabelBackgroundColour() }}; @if (\Illuminate\Support\Str::startsWith($event->colour, '#')) color: {{ $colours->contrastBW($event->colour) }};"@endif
                        @if ($canEdit)
@php unset($routeOptions[0]); unset($routeOptions['date']); @endphp
                            data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.entity_events.edit', ($event->calendar_id !== $model->id ? [$campaign, $event->entity->id, $event->id, 'from' => $model->calendar_id, 'next' => 'calendar.' . $model->id] : [$campaign, $event->entity->id, $event->id, 'next' => 'calendar.' . $model->id]) + $routeOptions) }}"
                        @else
                            data-url="{{ $event->entity->url() }}"
                        @endif
                        >
                        @if (Avatar::entity($event->entity)->hasImage())
                            <a href="{{ $event->entity->url() }}" class="hidden md:inline-block entity-image !w-7 !h-7 pull-left mr-1 cover-background" style="background-image: url('{{ Avatar::size(40)->thumbnail() }}');"></a>
                        @endif
                        <span data-toggle="tooltip-ajax" data-id="{{ $event->entity->id }}" data-url="{{ route('entities.tooltip', [$campaign, $event->entity]) }}" class="block">
                            {{ $event->entity->name }}
                            @if ($renderer->isEventStartDate($event, $day['date']))
                                <span class="text-xs">{{ __('calendars.events.start')}}</span>
                            @elseif ($renderer->isEventEndDate($event, $day['date']))
                                <span class="text-xs">{{ __('calendars.events.end')}}</span>
                            @endif
                        </span>
                        @if ($event->isBirth())
                            @if ($event->year === $day['year'])
                                <x-icon class="fa-solid fa-baby" title="{{ __('entities/events.types.birth') }}" tooltip="1" />
                            @else
                                <x-icon class="fa-solid fa-birthday-cake" title="{{ __('entities/events.types.birthday') }}" tooltip="1" />
                            @endif
                        @endif
                        @if ($event->isDeath())
                            <x-icon class="fa-solid fa-skull" title="{{ __('entities/events.types.death') }}" tooltip="1" />
                        @endif
                        {!! $event->getLabel() !!}
                    </div>
                @endforeach
            @endif
        @endif
        </div>
    </td>
@endif
