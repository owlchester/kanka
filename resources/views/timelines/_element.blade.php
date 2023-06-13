<?php
/**
 * @var \App\Models\Timeline $timeline
 * @var \App\Models\TimelineEra $era
 * @var \App\Models\TimelineElement $element
 */
?>
<li id="timeline-element-{{ $element->id }}" class="relative mr-2">
    {!! $element->htmlIcon() !!}

    <div class="timeline-item p-0 relative rounded-sm mt-0 ml-16 mr-4">
        <div class="box">
            <div class="box-header !flex gap-2">
                <h3 class="box-title grow cursor-pointer element-toggle {{ $element->collapsed() ? 'collapsed' : null }} !visible" data-toggle="collapse" data-target="#timeline-element-body-{{ $element->id }}">

                    <i class="fa-solid fa-chevron-up icon-show" aria-hidden="true"></i>
                    <i class="fa-solid fa-chevron-down icon-hide" aria-hidden="true"></i>
                    {!! $element->htmlName() !!}
                    @if (isset($element->date) || $element->use_event_date && isset($element->entity->event->date))
                        <span class="text-muted">{{isset($element->entity->event->date) && $element->use_event_date ? $element->entity->event->date : $element->date}}</span>
                    @endif
                    @if($element->entity && $element->entity->is_private)
                        <i class="fa-solid fa-lock" title="{{ __('timelines/elements.helpers.entity_is_private') }}" data-toggle="tooltip" ></i>
                    @endif
                </h3>
                <div class="flex items-center gap-2 ">
                    @if (auth()->check()) {!! $element->visibilityIcon('btn-box-tool') !!}@endif

                    @can('update', $timeline)
                        <div class="dropdown inline">
                            <a class="dropdown-toggle btn2 btn-xs btn-ghost" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape">
                                <i class="fa-solid fa-ellipsis-v" aria-hidden="true"></i>
                                <span class="sr-only">{{__('crud.actions.actions') }}'</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li>
                                    <a href="{{ route('timelines.timeline_elements.edit', [$timeline, $element, 'from' => 'view']) }}" title="{{ __('crud.edit') }}"
                                    >
                                        <x-icon class="edit"></x-icon> {{ __('crud.edit') }}
                                    </a>
                                </li>
                                <li class="text-red">
                                    <a href="#" class="delete-confirm" data-toggle="modal" data-name="{{ $element->elementName() }}"
                                       data-target="#delete-confirm" data-delete-target="delete-form-timeline-element-{{ $element->id }}"
                                       title="{{ __('crud.remove') }}">
                                        <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#" title="[timeline:{{ $timeline->entity->id }}|anchor:timeline-element-{{ $element->id }}]" data-toggle="tooltip"
                                       data-clipboard="[timeline:{{ $timeline->entity->id }}|anchor:timeline-element-{{ $element->id }}]" data-toast="{{ __('timelines/elements.copy_mention.success') }}">
                                        <i class="fa-solid fa-link" aria-hidden="true"></i> {{ __('entities/notes.copy_mention.copy') }}
                                    </a>
                                </li>
                                @php $mentionName = $element->mentionName() @endphp
                                <li>
                                    <a href="#" title="[timeline:{{ $timeline->entity->id }}|anchor:timeline-element-{{ $element->id }}]|{{ $mentionName }}" data-toggle="tooltip"
                                       data-clipboard="[timeline:{{ $timeline->entity->id }}|anchor:timeline-element-{{ $element->id }}|{{ $mentionName }}]" data-toast="{{ __('timelines/elements.copy_mention.success') }}">
                                        <i class="fa-solid fa-link" aria-hidden="true"></i> {{ __('timelines/elements.copy_mention.copy_with_name') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="box-body entity-content collapse {{ $element->collapsed() ? 'out' : 'in' }} !visible" id="timeline-element-body-{{ $element->id }}">
                {!! \App\Facades\Mentions::mapAny($element) !!}

                @if ($element->use_entity_entry && $element->entity && $element->entity->child->hasEntry())
                    <div class="timeline-entity-content">
                        {!! $element->entity->child->entry() !!}
                    </div>
                @endif
            </div>
        </div>
        {!! Form::hidden('element_ids[]', $element->id) !!}
    </div>
</li>
