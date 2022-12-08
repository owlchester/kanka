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

    <div class="box box-solid post entity-note box-widget" id="era{{ $era->id }}">
        <div class="box-header with-border">
            <h3 class="box-title cursor element-toggle timeline-era-toggle" data-toggle="collapse" data-target="#era-items-{{ $era->id }}" data-short="timeline-era-toggle-{{ $era->id }}">

                <i class="fa-solid fa-chevron-up" id="timeline-era-toggle-{{ $era->id }}-show" @if($era->collapsed()) style="display: none;" @endif></i>
                <i class="fa-solid fa-chevron-down" id="timeline-era-toggle-{{ $era->id }}-hide" @if(!$era->collapsed()) style="display: none;" @endif></i>

                {!! $era->name !!} @if(!empty($era->abbreviation)) ({{ $era->abbreviation }}) @endif

                <span class="text-sm">
                {!! $era->ages()!!}
            </span>

            </h3>

            <div class="box-tools">
                @can('update', $timeline)
                    <a href="{{ route('timelines.timeline_eras.edit', [$timeline, $era, 'from' => 'view']) }}"
                       class="btn btn-box-tool" role="button"
                       title="{{ __('crud.edit') }}"
                    >
                        <i class="fa-solid fa-edit"></i>
                    </a>

                    <a href="#" class="btn btn-box-tool text-red delete-confirm"
                       data-toggle="modal" data-name="{{ $era->name }}" role="button"
                       data-target="#delete-confirm" data-delete-target="delete-form-timeline-era-{{ $era->id }}"
                       title="{{ __('crud.remove') }}">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_eras.destroy', $timeline, $era, 'from' => 'view'], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-era-' . $era->id]) !!}
                    {!! Form::close() !!}
                @endcan
            </div>
        </div>
        <div class="box-body entity-content">
            {!! \App\Facades\Mentions::mapAny($era)  !!}
        </div>
    </div>

    <ul class="timeline collapse {{ $era->is_collapsed ? 'out' : 'in' }}" id="era-items-{{ $era->id }}">
    @foreach($era->orderedElements as $element)
        @php
            $position = $element->position + 1;
            $loadedElements[] = $element;
        @endphp
        @if(!empty($element->entity_id) && empty($element->entity->child))
            @continue
        @endif
        @include('timelines._element')
    @endforeach
    </ul>

    @can('update', $timeline)
        <div class="text-center mb-5">
            <a href="{{ route('timelines.timeline_elements.create', [$model, 'era_id' => $era, 'position' => $position]) }}" class="btn btn-primary btn-sm"
                title="{{ __('crud.create') }}"
            >
                <i class="fa-solid fa-plus"></i>
                <span class="hidden-xs inline">{!! __('timelines.actions.add_element', ['era' => $era->name]) !!}</span>
            </a>
        </div>
    @endcan
    </ul>
@empty
    <div class="alert alert-warning">
        <div class = "mb-2" >{{ __('timelines.helpers.no_era_v2') }} </div>
        @can('update', $timeline)
        <a href="{{ route('timelines.timeline_eras.create', ['timeline' => $model, 'from' => 'view']) }}" class="btn btn-warning btn-sm">
            <i class="fa-solid fa-plus"></i> {{ __('timelines/eras.actions.add') }}
        </a>
        @endcan
    </div>
@endforelse
@if (!$timeline->eras->isEmpty())
    @can('update', $timeline)
        <div class="text-center mb-5">
            <a href="{{ route('timelines.timeline_eras.create', ['timeline' => $model, 'from' => 'view']) }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> {{ __('timelines/eras.actions.add') }}
            </a>
        </div>
    @endcan
@endif


@if(!isset($printing) && auth()->check())
    @can('update', $timeline)
        @include('editors.editor')

        @if ($ajax)
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

            {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_elements.destroy', $timeline, $element, 'from' => 'view'], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-element-' . $element->id]) !!}
            {!! Form::close() !!}
        @endforeach
    @endcan
@endsection
