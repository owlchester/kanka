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

    <td class="h-24 text-center wrap-break-word align-top {{ $day['isToday'] ? 'today bg-base-200' : null }}" data-date="{{ \Illuminate\Support\Arr::get($day, 'date', null) }}" @if ($canEdit) data-dbclick data-url="{{ route('calendars.event.create', $routeOptions) }}" @endif>
        <div class="flex flex-col gap-1">
        @if ($day['day'])
            <div class="flex gap-1 items-center">
                <div class="text-base day-name {{ $day['isToday'] ? "badge badge-primary" : null}}">
                    <span class="day-number">{{ $day['day'] }}</span>
                    <span class="julian-number">{{ $day['julian'] }}</span>
                </div>
                <div class="grow truncate">
                @if ($day['day'] == 1 && !empty($showMonth))
                    <span class="hidden md:inline month-name">{{ $day['month'] }}</span>
                @endif
                </div>
                @if ($canEdit)
                <div class="dropdown">
                    <a class="btn2 btn-xs" data-dropdown aria-expanded="false" data-placement="right">
                        <i class="fa-regular fa-ellipsis-h" data-tree="escape"></i>
                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                    </a>

                    <div class="dropdown-menu hidden" role="menu">
                        @php $data = ['toggle' => 'dialog', 'date' => $day['date'], 'target' => 'primary-dialog', 'url' => route('calendars.event.create', $routeOptions)]; @endphp
                        <x-dropdowns.item link="#" :data="$data" icon="plus">
                            {{ __('calendars.actions.add_reminder') }}
                        </x-dropdowns.item>

                        @php $data = ['toggle' => 'dialog', 'date' => $day['date'], 'target' => 'primary-dialog', 'url' => route('calendars.calendar_weather.create', $routeOptions)]; @endphp
                        <x-dropdowns.item link="#" :data="$data" icon="fa-regular fa-snowflake">
                            {{ __('calendars.actions.' .  (!empty($day['weather']) ? 'update_weather' : 'add_weather')) }}
                        </x-dropdowns.item>

                        @if (!\Illuminate\Support\Arr::get($day, 'isToday', false))
                            <x-dropdowns.divider />
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
                    <i class="moon {{ $moon['class'] }}"  style="color:{{ \Illuminate\Support\Arr::get($moon, 'colour', '#6B7280')}};" data-title="{{ __('calendars.show.moon_' . $moon['type'], ['moon' => $moon['name']]) }}" data-toggle="tooltip"></i>
                @endforeach
            @endif
            @if (!empty($day['season']))
                <div class="badge calendar-season bg-season block w-full text-xs!" data-toggle="tooltip" data-title="{{ __('calendars.parameters.seasons.name') }}">
                    {{ $day['season'] }}
                </div>
            @endif

            @if (!empty($day['weather']))
                <div class="weather weather-{{ $day['weather']->weather }}" data-html="true" data-toggle="tooltip" data-title="{!! $day['weather']->tooltip() !!}">
                    <x-icon class="fa-solid fa-{{ $day['weather']->weather }}" />
                    {{ $day['weather']->weatherName() }}
                </div>
            @endif
            @if (!empty($day['events']))
                @foreach ($day['events'] as $event)
                    <div class="calendar-event-block text-left rounded-sm p-1 relative cursor-pointer text-sm flex gap-1 flex-col   {{ $event->getLabelColour() }}" style="background-color: {{ $event->getLabelBackgroundColour() }}; @if (\Illuminate\Support\Str::startsWith($event->colour, '#')) color: {{ $colours->contrastBW($event->colour) }};"@endif
                        @if ($canEdit && $event->isEntity())
                            @php unset($routeOptions[0]); unset($routeOptions['date']); @endphp
                            data-toggle="dialog" data-url="{{ route('reminders.edit', ($event->calendar_id !== $model->id ? [$campaign, $event->id, 'from' => $model->calendar_id, 'next' => 'calendar.' . $model->id] : [$campaign, $event->id, 'next' => 'calendar.' . $model->id]) + $routeOptions) }}"

                        @elseif ($canEdit && $event->isPost())
                            @php unset($routeOptions[0]); unset($routeOptions['date']); @endphp
                            data-toggle="dialog" data-url="{{ route('reminders.edit', ($event->calendar_id !== $model->id ? [$campaign, $event->id, 'from' => $model->calendar_id, 'next' => 'calendar.' . $model->id] : [$campaign, $event->id, 'next' => 'calendar.' . $model->id]) + $routeOptions) }}"
                        @elseif ($event->isPost())
                            data-url="{{ route('entities.show', [$campaign, $event->remindable->entity, '#post-' . $event->remindable_id]) }}"
                        @else
                            data-url="{{ $event->remindable->url() }}"
                        @endif
                        >
                        <div class="flex gap-1 items-center">
                            @if ($event->isEntity() && Avatar::entity($event->remindable)->hasImage())
                                <div class="hidden md:inline grow-0">
                                    <a href="{{ $event->remindable->url() }}" class="entity-image w-7 h-7 cover-background" style="background-image: url('{{ Avatar::size(40)->thumbnail() }}');"></a>
                                </div>
                            @endif

                            <span data-toggle="tooltip-ajax" data-id="{{ $event->isEntity() ? $event->remindable->id : $event->remindable->entity->id}}" data-url="{{ route('entities.tooltip', [$campaign, $event->remindable->entity ?? $event->remindable]) }}" class="grow truncate">
                                {{ $event->remindable->name }}
                                @if ($renderer->isEventStartDate($event, $day['date']))
                                    <span class="text-xs">{{ __('calendars.events.start')}}</span>
                                @elseif ($renderer->isEventEndDate($event, $day['date']))
                                    <span class="text-xs">{{ __('calendars.events.end')}}</span>
                                @endif
                            </span>
                            @if ($event->isBirth())
                                @if ($event->year === $day['year'])
                                    <x-icon class="fa-regular fa-baby" title="{{ __('entities/events.types.birth') }}" tooltip />
                                @else
                                    <x-icon class="fa-regular fa-birthday-cake" title="{{ __('entities/events.types.birthday') }}" tooltip />
                                @endif
                            @endif
                            @if ($event->isDeath())
                                <x-icon class="fa-regular fa-skull" title="{{ __('entities/events.types.death') }}" tooltip />
                            @endif
                            @if ($event->is_recurring)
                                <x-icon class="fa-regular fa-arrows-rotate" tooltip :title="__('calendars.fields.is_recurring')" />
                            @endif
                        </div>
                        <div class="reminder-comment">
                            @if (!empty($event->comment))
                            <span class="calendar-event-comment grow text-xs" data-toggle="tooltip" data-title="{{ $event->comment }}">
                                {!! $event->comment !!}
                            </span>
                            @endif

                        </div>
                    </div>
                @endforeach
            @endif
        @endif
        </div>
    </td>
@endif
