<?php /** @var \App\Models\QuestElement[] $elements */?>
@php $count = 0; @endphp

<div class="" id="quest-elements">
    <x-grid>
    @foreach ($elements as $element)
        @if ($element->entity_id && !$element->entity)
            @continue
        @endif
        @php $count++; @endphp
            <div class="rounded flex flex-col bg-box widget-user-2 box-quest-element" id="quest-element-{{ $element->id }}" @if ($element->entity)data-entity-id="{{ $element->entity->id }}" data-entity-type="{{ $element->entity->type() }}"@endif>
                <div class="flex p-4 gap-2 items-center border-b h-20 {{ $element->colourClass() }}">
                    @if ($element->entity && $element->entity->hasImage($campaign->boosted()))
                        <div class="widget-user-image">
                            <img class="flex-none entity-image rounded-full pull-left" src="{{ Avatar::entity($element->entity)->size(40)->thumbnail() }}" title="{{ $element->entity->name }}" alt="{{ $element->entity->name }}" />
                        </div>
                    @endif

                    <div class="grow">
                        <h3 class="widget-user-username text-2xl ">
                            @if($element->entity)
                                @if ($element->entity->is_private)
                                    <i class="fa-solid fa-lock" aria-hidden="true" aria-label="{{ __('crud.is_private') }}" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                                @endif
                                    <x-entity-link
                                        :entity="$element->entity"
                                        :name="$element->name"
                                        :campaign="$campaign" />
                            @else
                                <span class="name truncate">
                                    {!! $element->name !!}
                                </span>
                            @endif
                        </h3>
                        @if (!empty($element->role))
                            <h5 class="m-0">{!! $element->role !!}</h5>
                        @endif
                    </div>
                </div>
                <div class="p-4 flex-1 entity-content">
                    {!! $element->parsedEntry() !!}
                </div>
                <div class="p-4 flex gap-2 items-center mt-auto">
                    <div class="grow">
                        @include('icons.visibility', ['icon' => $element->visibilityIcon()])
                    </div>
                    @can('update', $model)
                        <div class="flex gap-2 items-center">
                            <x-button.delete-confirm target="#delete-form-{{ $element->id }}" size="sm" />

                            <a href="{{ route('quests.quest_elements.edit', [$campaign, $model, $element]) }}" class="btn2 btn-sm btn-primary">
                                <x-icon class="edit"></x-icon>
                                {{ __('crud.edit') }}
                            </a>
                        </div>

                        <x-form method="DELETE" :action="['quests.quest_elements.destroy', $campaign, $model, $element]" id="delete-form-{{ $element->id }}" />
                    @endcan
                </div>
            </div>
    @endforeach
    </x-grid>
</div>

<div class="text-right">
    {!! $elements->fragment('quest-elements')->links() !!}
</div>
