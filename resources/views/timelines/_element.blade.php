<?php
/**
 * @var \App\Models\Timeline $timeline
 * @var \App\Models\TimelineEra $era
 * @var \App\Models\TimelineElement $element
 */
?>
<li id="timeline-element-{{ $element->id }}">
    {!! $element->htmlIcon() !!}

    <div class="timeline-item">
        <span class="time">
            @include('cruds.partials.visibility', ['model' => $element, 'rightMargin' => true])

        @can('update', $timeline)

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
        @endcan

            </span>

        <h3 class="timeline-header cursor entity-note-toggle" data-toggle="collapse" data-target="#timeline-element-body-{{ $element->id }}" data-short="timeline-element-body-toggle-{{ $element->id }}">
            <i class="fa fa-chevron-up" id="timeline-element-body-toggle-{{ $element->id }}-show" @if($element->collapsed()) style="display: none;" @endif></i>
            <i class="fa fa-chevron-down" id="timeline-element-body-toggle-{{ $element->id }}-hide" @if(!$element->collapsed()) style="display: none;" @endif></i>

            {!! $element->htmlName() !!}
            @if(isset($element->date))<span class="text-muted">{{ $element->date }}</span>@endif

            @if($element->entity && $element->entity->is_private)
                <i class="fas fa-lock" title="{{ __('timelines/elements.helpers.entity_is_private') }}" data-toggle="tooltip" ></i>
            @endif
        </h3>

        <div class="timeline-body entity-content collapse {{ $element->collapsed() ? 'out' : 'in' }}" id="timeline-element-body-{{ $element->id }}">
            {!! \App\Facades\Mentions::mapAny($element) !!}

            @if ($element->use_entity_entry && $element->entity && $element->entity->child->hasEntry())
                <div class="timeline-entity-content">
                    {!! $element->entity->child->entry() !!}
                </div>
            @endif
        </div>
        {!! Form::hidden('element_ids[]', $element->id) !!}
    </div>
</li>
