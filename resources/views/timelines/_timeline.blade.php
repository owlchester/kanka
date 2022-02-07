<?php
/**
 * @var \App\Models\Timeline $timeline
 * @var \App\Models\TimelineEra $era
 * @var \App\Models\TimelineElement $element
 */
$eras = $timeline->eras()->ordered($timeline->revert_order)->get();
?>
@foreach ($eras as $era)
    @php
    $position = 1;
    @endphp

    <div class="box box-solid entity-note box-widget" id="era{{ $era->id }}">
        <div class="box-header with-border">
            <h3 class="box-title cursor entity-note-toggle" data-toggle="collapse" data-target="#era-items-{{ $era->id }}" data-short="timeline-era-toggle-{{ $era->id }}">

                <i class="fa fa-chevron-up" id="timeline-era-toggle-{{ $era->id }}-show" @if($era->collapsed()) style="display: none;" @endif></i>
                <i class="fa fa-chevron-down" id="timeline-era-toggle-{{ $era->id }}-hide" @if(!$era->collapsed()) style="display: none;" @endif></i>

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
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" class="btn btn-box-tool text-red delete-confirm"
                       data-toggle="modal" data-name="{{ $era->name }}" role="button"
                       data-target="#delete-confirm" data-delete-target="delete-form-timeline-era-{{ $era->id }}"
                       title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
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

    @can('update', $timeline)
        {!! Form::open(['route' => ['timelines.reorder', $timeline, $era], 'method' => 'POST']) !!}
    @endcan

    <ul class="timeline collapse {{ $era->is_collapsed ? 'out' : 'in' }}" id="era-items-{{ $era->id }}">
    @foreach($era->elements()->ordered()->get() as $element)
        @php
            $position = $element->position + 1;
        @endphp
        @if(!empty($element->entity_id) && empty($element->entity->child))
            @continue
        @endif
        <li id="element{{ $element->id }}">
            {!! $element->htmlIcon() !!}

            <div class="timeline-item">
                @can('update', $timeline)
                    <span class="time">

                        <a href="{{ route('timelines.timeline_elements.edit', [$timeline, $element, 'from' => 'view']) }}" class="margin-r-5"
                           title="{{ __('crud.edit') }}"
                        >
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="text-red delete-confirm" data-toggle="modal" data-name="{{ $element->elementName() }}"
                           data-target="#delete-confirm" data-delete-target="delete-form-timeline-element-{{ $element->id }}"
                           title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </span>
                @endcan

                <h3 class="timeline-header cursor entity-note-toggle" data-toggle="collapse" data-target="#timeline-element-{{ $element->id }}" data-short="timeline-element-toggle-{{ $element->id }}">
                    <i class="fa fa-chevron-up" id="timeline-element-toggle-{{ $element->id }}-show"></i>
                    <i class="fa fa-chevron-down" id="timeline-element-toggle-{{ $element->id }}-hide" style="display:none"></i>

                    {!! $element->htmlName() !!}
                    @if(isset($element->date))<span class="text-muted">{{ $element->date }}</span>@endif

                    @if($element->entity && $element->entity->is_private)
                        <i class="fas fa-lock" title="{{ __('timelines/elements.helpers.entity_is_private') }}" data-toggle="tooltip" ></i>
                    @endif
                    @include('cruds.partials.visibility', ['model' => $element])
                </h3>

                <div class="timeline-body entity-content collapse in" id="timeline-element-{{ $element->id }}">
                    {!! \App\Facades\Mentions::mapAny($element) !!}
                </div>
                    {!! Form::hidden('element_ids[]', $element->id) !!}
            </div>
        </li>
    @endforeach
    </ul>

    @can('update', $timeline)
        <div class="text-center margin-bottom">
            <a href="{{ route('timelines.timeline_elements.create', [$model, 'era_id' => $era, 'position' => $position]) }}" class="btn btn-primary btn-sm"
                title="{{ __('crud.create') }}"
            >
                <i class="fa fa-plus"></i>
                <span class="hidden-xs inline">{!! __('timelines.actions.add_element', ['era' => $era->name]) !!}</span>
            </a>
            @if($era->elements()->count() > 1)
            <a href="#" class="timeline-era-reorder btn btn-default btn-sm" data-era-id="{{ $era->id }}" data-toggle="tooltip" title="{{ __('timelines.helpers.reorder_tooltip') }}">
                <i class="fa fa-arrows-alt-v"></i> {{ __('timelines.actions.reorder') }}
            </a>
            @endif
        </div>
        <div style="display:none;" class="text-center margin-bottom" id="era-items-{{ $era->id }}-save-reorder">
            <p class="text-muted">{{ __('timelines.helpers.reorder') }}</p>

            <button type="submit" class="btn btn-primary">
                {{ __('timelines.actions.save_order') }}
            </button>
        </div>
        {!! Form::close() !!}
    @endcan
    </ul>
@endforeach



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
        @foreach ($eras as $era)
            @foreach($era->elements as $element)
                @php
                    $position = $element->position + 1;
                @endphp
                @if(!empty($element->entity_id) && empty($element->entity->child))
                    @continue
                @endif

                {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_elements.destroy', $timeline, $element, 'from' => 'view'], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-element-' . $element->id]) !!}
                {!! Form::close() !!}
            @endforeach
        @endforeach
    @endcan
@endsection
