<?php
/**
 * @var \App\Models\Timeline $timeline
 * @var \App\Models\TimelineEra $era
 * @var \App\Models\TimelineElement $element
 */
$eras = $timeline->eras()->with(['orderedElements', 'orderedElements.entity', 'orderedElements.entity.event'])->ordered()->get();
$loadedElements = [];
?>
@forelse ($eras as $era)
    @php
    $position = 1;
    @endphp

    <x-box css="flex gap-2 flex-col p-2 timeline-era post entity-note" :padding="0" id="era{{ $era->id }}">
        <div class="timeline-era-head flex gap-2 items-center">
            <h3 class="grow cursor-pointer flex gap-2 items-center element-toggle text-base m-0 {{ $era->collapsed() ? 'animate-collapsed' : null }}" data-animate="collapse" data-target="#era-items-{{ $era->id }}">

                <i class="fa-solid fa-chevron-up icon-show" aria-hidden="true"></i>
                <i class="fa-solid fa-chevron-down icon-hide" aria-hidden="true"></i>

                {!! $era->name !!} @if(!empty($era->abbreviation)) ({{ $era->abbreviation }}) @endif

                <span class="text-xs">
                    {!! $era->ages()!!}
                </span>
            </h3>

            <div class="flex-none flex items-center gap-2">
                @can('update', $timeline)
                    <a href="{{ route('timelines.timeline_eras.edit', [$campaign, $timeline, $era, 'from' => 'view']) }}"
                       class="btn2 btn-ghost btn-xs " role="button"
                       title="{{ __('crud.edit') }}"
                    >
                        <x-icon class="edit" />
                        <span class="sr-only">{{ __('crud.edit') }}</span>
                    </a>

                    <a href="#" class="btn2 btn-ghost btn-xs text-error
                       role="button"
                       data-toggle="dialog"
                       data-target="primary-dialog"
                       data-url="{{ route('confirm-delete', [$campaign, 'route' => route('timelines.timeline_eras.destroy', [$campaign, $timeline, $era, 'from' => 'view']), 'name' => $era->name, 'permanent' => true]) }}"
                       title="{{ __('crud.remove') }}">
                        <x-icon class="trash" />
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </a>
                @endcan
            </div>
        </div>
        <div class="timeline-era-body entity-content">
            {!! \App\Facades\Mentions::mapAny($era)  !!}
        </div>
    </x-box>

    <ul class="timeline relative m-0 p-0 list-none @if ($era->collapsed()) hidden @endif" id="era-items-{{ $era->id }}">
    @foreach($era->orderedElements as $element)
        @php
            $position = $element->position + 1;
            $loadedElements[] = $element;
        @endphp
        @includeWhen($element->visible(), 'timelines._element')
    @endforeach
    </ul>

    @can('update', $timeline)
        <div class="text-center">
            <a href="{{ route('timelines.timeline_elements.create', [$campaign, $model, 'era_id' => $era, 'position' => $position]) }}" class="btn2 btn-primary btn-sm"
                title="{{ __('crud.create') }}"
            >
                <x-icon class="plus" />
                <span class="hidden lg:inline">{!! __('timelines.actions.add_element', ['era' => $era->name]) !!}</span>
            </a>
        </div>
    @endcan
    </ul>
@empty
    <x-alert type="warning">
        <x-grid type="1/1">
            <p>
                {{ __('timelines.helpers.no_era_v2') }}
            </p>
            @can('update', $timeline)
                <div>
            <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model, 'from' => 'view']) }}" class="btn2 btn-sm">
                <x-icon class="plus"></x-icon> {{ __('timelines/eras.actions.add') }}
            </a></div>
            @endcan
        </x-grid>
    </x-alert>
@endforelse
@if (!$timeline->eras->isEmpty())
    @can('update', $timeline)
        <div class="text-center">
            <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model, 'from' => 'view']) }}" class="btn2 btn-primary btn-sm">
                <x-icon class="plus" />
                {{ __('timelines/eras.actions.add') }}
            </a>
        </div>
    @endcan
@endif



