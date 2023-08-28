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

    <x-box css="flex gap-2 flex-col p-2 timeline-era entity-note" :padding="0" id="era{{ $era->id }}">
        <div class="timeline-era-head flex gap-2 items-center">
            <h3 class="cursor-pointer grow element-toggle text-base {{ $era->collapsed() ? 'collapsed' : null }}" data-toggle="collapse" data-target="#era-items-{{ $era->id }}">

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
                        <x-icon class="edit"></x-icon>
                        <span class="sr-only">{{ __('crud.edit') }}</span>
                    </a>

                    <a href="#" class="btn2 btn-ghost btn-xs text-red delete-confirm"
                       data-toggle="modal" data-name="{{ $era->name }}" role="button"
                       data-target="#delete-confirm" data-delete-target="delete-form-timeline-era-{{ $era->id }}"
                       title="{{ __('crud.remove') }}">
                        <x-icon class="trash"></x-icon>
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_eras.destroy', $campaign, $timeline, $era, 'from' => 'view'], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-era-' . $era->id]) !!}
                    {!! Form::close() !!}
                @endcan
            </div>
        </div>
        <div class="timeline-era-body entity-content">
            {!! \App\Facades\Mentions::mapAny($era)  !!}
        </div>
    </x-box>

    <ul class="timeline relative m-0 p-0 list-none collapse {{ $era->is_collapsed ? 'out' : 'in' }} !visible" id="era-items-{{ $era->id }}">
    @foreach($era->orderedElements as $element)
        @php
            $position = $element->position + 1;
            $loadedElements[] = $element;
        @endphp
        @includeWhen($element->visible(), 'timelines._element')
    @endforeach
    </ul>

    @can('update', $timeline)
        <div class="text-center mb-5">
            <a href="{{ route('timelines.timeline_elements.create', [$campaign, $model, 'era_id' => $era, 'position' => $position]) }}" class="btn2 btn-primary btn-sm"
                title="{{ __('crud.create') }}"
            >
                <x-icon class="plus"></x-icon>
                <span class="hidden lg:inline">{!! __('timelines.actions.add_element', ['era' => $era->name]) !!}</span>
            </a>
        </div>
    @endcan
    </ul>
@empty
    <x-alert type="warning">
        <div class = "mb-2" >{{ __('timelines.helpers.no_era_v2') }} </div>
        @can('update', $timeline)
        <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model, 'from' => 'view']) }}" class="btn2 btn-accent btn-sm">
            <x-icon class="plus"></x-icon> {{ __('timelines/eras.actions.add') }}
        </a>
        @endcan
    </x-alert>
@endforelse
@if (!$timeline->eras->isEmpty())
    @can('update', $timeline)
        <div class="text-center mb-5">
            <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model, 'from' => 'view']) }}" class="btn2 btn-primary btn-sm">
                <x-icon class="plus"></x-icon> {{ __('timelines/eras.actions.add') }}
            </a>
        </div>
    @endcan
@endif


@if(!isset($printing) && auth()->check())
    @can('update', $timeline)
        @include('editors.editor')

        @if (request()->ajax())
            <script type="text/javascript">
                $(document).ready(function () {
    @if(auth()->user()->editor != 'legacy')
                        window.initSummernote();
    @else
                        var editorId = 'element-entry';
                        // First we remove in case it was already loaded
                        tinyMCE.EditorManager.execCommand('mceFocus', false, editorId);
                        tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, editorId);
                        // And add again
                        tinymce.EditorManager.execCommand('mceAddEditor', false, editorId);
    @endif
                });
            </script>
        @endif
    @endcan
@endif


@section('modals')
    @can('update', $timeline)
        @foreach($loadedElements as $element)
            @php
                $position = $element->position + 1;
            @endphp
            @if(!empty($element->entity_id) && empty($element->entity->child))
                @continue
            @endif

            {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_elements.destroy', $campaign, $timeline, $element, 'from' => 'view'], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-element-' . $element->id]) !!}
            {!! Form::close() !!}
        @endforeach
    @endcan
@endsection
