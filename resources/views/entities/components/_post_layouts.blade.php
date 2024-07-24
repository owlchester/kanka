<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
*/
?>
<div class="flex flex-col gap-2 post-block post-{{ $post->id }} post-position-{{ $post->position }}@if (isset($post->settings['class'])) {{ $post->settings['class'] }}@endif" data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}">
    <div class="flex gap-2 items-center">
        <h3 class="grow" >
            {{ $post->name  }}
            @if (app()->environment('local'))
                <sup class="text-xs">({{ $post->position }})</sup>
            @endif
        </h3>
        <div class="post-buttons flex items-center gap-2 flex-wrap justify-end">
            @if (auth()->check())
                {!! $post->visibilityIcon('') !!}
                <div class="dropdown">
                    <a role="button" class="btn2 btn-ghost btn-sm" data-dropdown aria-expanded="false" data-tree="escape">
                        <x-icon class="fa-solid fa-ellipsis-v" />
                        <span class="sr-only">{{__('crud.actions.actions') }}</span>
                    </a>
                    <div class="dropdown-menu hidden" role="menu">
                        @include('entities.pages.posts._actions')
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($post->layout?->code == 'inventory')
        @php
            $inventory = $entity
                ->inventories()
                ->with(['entity', 'item', 'item.entity'])
                ->get()
                ->sortBy(function ($model, $key) {
                    return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
                });
        @endphp
        @include('entities.pages.inventory._grid', ['inventory' => $inventory, 'isPost' => true, 'entity' => $entity, 'ajax' => null])
    @elseif ($post->layout?->code == 'attributes')
        <x-box css="box-entity-attributes">
            @include('entities.pages.attributes.render', ['isPost' => true])
        </x-box>
        <input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
    @elseif ($post->layout?->code == 'abilities')
        @php
        $translations = [
            'all' => __('crud.visibilities.all'),
            'members' => __('crud.visibilities.members'),
            'admin-self' => __('crud.visibilities.admin-self'),
            'admin' => __('crud.visibilities.admin'),
            'self' => __('crud.visibilities.self'),
            'update' => __('crud.update'),
            'remove' => __('crud.remove'),
        ];
        $translations = json_encode($translations);
        @endphp
        @include('entities.pages.abilities._abilities', ['isPost' => true])
    @elseif ($post->layout?->code == 'assets')
        @include('entities.pages.assets._assets', ['assets' => $entity->assets, 'isPost' => true])
    @elseif ($post->layout?->code == 'connection_map')
        @include('entities.pages.relations._map', ['option' => null, 'isPost' => true, 'mode' => 'map'])
    @elseif ($post->layout?->code == 'character_orgs')
        @include('characters.panels.organisations', ['character' => $entity->child])
    @elseif ($post->layout?->code == 'quest_elements')
        @php
            $elements = $entity->child
                    ->elements()
                    ->paginate();
            $elements->withPath(route('quests.quest_elements.index', [$campaign, $entity->child]));
        @endphp
        @include('quests.elements._elements', ['elements' => $elements])
    @elseif ($post->layout?->code == 'location_characters')
        @php
            $options = [$campaign, 'location' => $entity->child];

            Datagrid::layout(\App\Renderers\Layouts\Location\Character::class)
                ->route('locations.characters', $options);

            $rows = $entity->child
                ->allCharacters()
                ->filteredCharacters()
                ->paginate();
            $rows->withPath(route('locations.characters', $options));

        @endphp
        @include('locations.panels.characters')
    @elseif ($post->layout?->code == 'reminders')
        @php
        Datagrid::layout(\App\Renderers\Layouts\Entity\Reminder::class)
            ->route('entities.entity_events.index', ['campaign' => $campaign, 'entity' => $entity]);

        $rows = $entity
            ->events()
            ->has('calendar')
            ->has('calendar.entity')
            ->with(['calendar', 'calendar.entity', 'entity'])
            ->sort(request()->only(['o', 'k']))
            ->paginate();
        @endphp
        @if ($rows->count() > 0)
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
        @endif
    @endif
</div>
