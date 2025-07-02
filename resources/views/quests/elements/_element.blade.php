<?php /** @var \App\Models\QuestElement $element */?>
<article class="rounded flex flex-col bg-box widget-user-2 box-quest-element" id="quest-element-{{ $element->id }}" @if ($element->entity)data-entity-id="{{ $element->entity->id }}" data-entity-type="{{ $element->entity->entityType->code }}"@endif data-word-count="{{ $element->words }}">
    <div class="flex p-4 gap-2 items-center border-b h-20 {{ $element->colourClass() }}">
        @if ($element->entity && $element->entity->hasImage())
            <div class="widget-user-image">
                <img class="flex-none entity-image rounded-full pull-left w-10 h-10" src="{{ Avatar::entity($element->entity)->size(40)->thumbnail() }}" title="{{ $element->entity->name }}" alt="{{ $element->entity->name }}" />
            </div>
        @endif
        <div class="flex flex-col gap-1 truncate">
            <h3 class="widget-user-username text-2xl truncate">
                @if($element->entity)
                    @if ($element->entity->is_private)
                        <x-icon class="lock" title="{{ __('crud.is_private') }}" tooltip></x-icon>
                    @endif
                    <x-entity-link
                        :entity="$element->entity"
                        :campaign="$campaign">
                        {!! $element->name !!}
                    </x-entity-link>
                @else
                    <span class="name truncate">
                                    {!! $element->name !!}
                                </span>
                @endif
            </h3>
            @if (!empty($element->role))
                <h5 class="quest-element-role m-0 truncate">{!! $element->role !!}</h5>
            @endif
        </div>
    </div>
    <div class="p-4 flex-1 entity-content">
        {!! $element->parsedEntry() !!}
        <x-word-count :count="$element->words" />
    </div>
    <div class="p-4 flex gap-2 items-center justify-between flex-wrap">
        <div class="">
            @include('icons.visibility', ['icon' => $element->visibilityIcon()])
        </div>
        @can('update', $entity)
            <div class="flex gap-2 items-center flex-wrap">
                <x-button.delete-confirm target="#delete-form-{{ $element->id }}" size="sm" />

                <a href="{{ route('quests.quest_elements.edit', [$campaign, $model, $element]) }}" class="btn2 btn-sm btn-primary">
                    <x-icon class="edit" />
                    <span class="hidden md:inline">{{ __('crud.edit') }}</span>
                </a>
            </div>
        @endcan

    </div>

    @can('update', $entity)
        <x-form method="DELETE" :action="['quests.quest_elements.destroy', $campaign, $model, $element]" id="delete-form-{{ $element->id }}" />
    @endcan

</article>

