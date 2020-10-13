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

    <div class="box box-widget" id="era{{ $era->id }}">
        <div class="box-header with-border">
            <div class="box-title">{{ $era->name }} @if(!empty($era->abbreviation)) ({{ $era->abbreviation }}) @endif</div>
            <span>
                @if (isset($era->start_year) && isset($era->end_year))
                    {{ $era->start_year }} &mdash; {{ $era->end_year }}
                @elseif(!isset($era->start_year))
                    < {{ $era->end_year }}
                @elseif(!isset($era->end_year))
                    > {{ $era->start_year }}
                @else

                @endif
            </span>

            @can('update', $timeline)
                <div class="pull-right">
                    <a href="{{ route('timelines.timeline_eras.edit', [$timeline, $era, 'from' => 'view']) }}" class="margin-r-5"
                       title="{{ __('crud.edit') }}"
                    >
                        <i class="fa fa-pencil"></i>
                    </a>

                    <a href="#" class="text-red delete-confirm" data-toggle="modal" data-name="{{ $era->name }}"
                       data-target="#delete-confirm" data-delete-target="delete-form-timeline-era-{{ $era->id }}"
                       title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_eras.destroy', $timeline, $era], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-era-' . $era->id]) !!}
                    {!! Form::close() !!}
                </div>
            @endcan
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! \App\Facades\Mentions::mapAny($era)  !!}

            <div class="text-right">
                <i class="fa fa-chevron-up timeline-toggle" id="era-items-{{ $era->id }}-show" data-short="era-items-{{ $era->id }}" data-toggle="collapse" data-target="#era-items-{{ $era->id }}"></i>
                <i class="fa fa-chevron-down timeline-toggle" style="display: none;" id="era-items-{{ $era->id }}-hide" data-short="era-items-{{ $era->id }}" data-toggle="collapse" data-target="#era-items-{{ $era->id }}"></i>
            </div>
        </div>
    </div>

    @can('update', $timeline)
        {!! Form::open(['route' => ['timelines.reorder', $timeline, $era], 'method' => 'POST']) !!}
    @endcan

    <ul class="timeline collapse in" id="era-items-{{ $era->id }}" class="collapse in">
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
                            <i class="fa fa-pencil"></i>
                        </a>

                        <a href="#" class="text-red delete-confirm" data-toggle="modal" data-name="{{ $element->elementName() }}"
                           data-target="#delete-confirm" data-delete-target="delete-form-timeline-element-{{ $element->id }}"
                           title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </span>
                @endcan

                <h3 class="timeline-header">
                    {!! $element->htmlName() !!} @if(isset($element->date))<span class="text-muted">{{ $element->date }}</span>@endif
                </h3>

                <div class="timeline-body">
                    {!! \App\Facades\Mentions::mapAny($element) !!}
                </div>
                <div class="timeline-footer">
                    {!! Form::hidden('element_ids[]', $element->id) !!}
                </div>
            </div>
        </li>
    @endforeach
    </ul>

    @can('update', $timeline)
        <div class="text-center margin-bottom">
                <a href="{{ route('timelines.timeline_elements.create', [$model, 'era_id' => $era, 'position' => $position]) }}" class="btn btn-primary"
                    title="{{ __('crud.create') }}"
                    data-toggle="ajax-modal" data-target="#entity-modal"
                    data-url="{{ route('timelines.timeline_elements.create', [$model, 'era_id' => $era, 'position' => $position]) }}"
                >
                    <i class="fa fa-plus"></i>
                    <span class="hidden-xs inline">{{  __('timelines.actions.add_element', ['era' => $era->name]) }}</span>
                </a>
                @if($era->elements()->count() > 1)
                <a href="#" class="timeline-era-reorder btn btn-default" data-era-id="{{ $era->id }}" data-toggle="tooltip" title="{{ __('timelines.helpers.reorder_tooltip') }}">
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



@if(!isset($exporting) && auth()->check())
    @can('update', $timeline)
        @include('editors.editor')

        @if ($ajax)
            <script type="text/javascript">
                $(document).ready(function () {
    @if(auth()->user()->editor == 'summernote')
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

                {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_elements.destroy', $timeline, $element], 'style '=> 'display:inline', 'id' => 'delete-form-timeline-element-' . $element->id]) !!}
                {!! Form::close() !!}
            @endforeach
        @endforeach
    @endcan
@endsection
