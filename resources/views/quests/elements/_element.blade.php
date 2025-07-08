<?php /** @var \App\Models\QuestElement $element */?>
<article class="rounded overflow-hidden flex flex-col bg-box widget-user-2 box-quest-element" id="quest-element-{{ $element->id }}" @if ($element->entity)data-entity-id="{{ $element->entity->id }}" data-entity-type="{{ $element->entity->entityType->code }}"@endif data-word-count="{{ $element->words }}">
    <div class="flex p-4 gap-4 items-center border-b h-20 {{ $element->colourClass() }}">
        @if ($element->entity && $element->entity->hasImage())
            <img class="flex-none entity-image rounded-full pull-left w-10 h-10" src="{{ Avatar::entity($element->entity)->size(80)->thumbnail() }}" title="{{ $element->entity->name }}" alt="{{ $element->entity->name }}" />

        @endif
        <div class="flex flex-col grow gap-1 truncate">
            <h3 class="widget-user-username truncate m-0 p-0">
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
                    <span class="name">
                        {!! $element->name !!}
                    </span>
                @endif
            </h3>
            @if (!empty($element->role))
                <h5 class="quest-element-role m-0 truncate">{!! $element->role !!}</h5>
            @endif
        </div>
            @can('update', $entity)
                <div class="dropdown">
                    <a role="button" class="btn2 btn-ghost btn-sm" data-dropdown aria-expanded="false" data-tree="escape">
                        <x-icon class="fa-regular fa-ellipsis-v" />
                        <span class="sr-only">{{__('crud.actions.actions') }}</span>
                    </a>
                    <div class="dropdown-menu hidden" role="menu">
                        @include('quests.elements._actions')
                    </div>
                </div>
            @endcan
    </div>
    <div class="p-4 flex-1 entity-content">
        {!! $element->parsedEntry() !!}

        <div class="flex justify-between">

            @include('icons.visibility', ['icon' => $element->visibilityIcon()])
            <x-word-count :count="$element->words" />
        </div>
    </div>

</article>

