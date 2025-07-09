<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
*/
/** @var \App\Models\Tag[] $entityTags */
$entityTags = $post->visibleTags;
?>
<article id="post-{{ $post->id }}" class="flex flex-col gap-2 post-block post-{{ $post->id }} post-position-{{ $post->position }}@if (isset($post->settings['class'])) {{ $post->settings['class'] }}@endif @foreach ($entityTags as $tag) tag-{{ $tag->slug }} @endforeach" data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}" data-word-count="{{ $post->words }}">
    <div class="post-header flex gap-1 md:gap-2 items-center justify-between overflow-hidden">
        <h3 class="post-title truncate" >
            {!! $post->name !!}
        </h3>
        <div class="post-buttons flex gap-1 md:gap-2 items-center flex-wrap">
            @if (app()->hasDebugModeEnabled())
                <span class="text-xs text-neutral-content">({{ $post->position }})</span>
            @endif
            @auth
                @can('visibility', $post)
                    <span id="visibility-icon-{{ $post->id }}" class="btn2 btn-ghost btn-sm" data-toggle="dialog" data-url="{{ route('posts.edit.visibility', [$campaign, $entity->id, $post->id]) }}" data-target="primary-dialog">
                    @include('icons.visibility', ['icon' => $post->visibilityIcon()])
                </span>
                @else
                    @include('icons.visibility', ['icon' => $post->visibilityIcon()])
                @endif
                <div class="dropdown">
                    <a role="button" class="btn2 btn-ghost btn-sm" data-dropdown aria-expanded="false" data-tree="escape">
                        <x-icon class="fa-regular fa-ellipsis-v" />
                        <span class="sr-only">{{__('crud.actions.actions') }}</span>
                    </a>
                    <div class="dropdown-menu hidden" role="menu">
                        @include('entities.pages.posts._actions')
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-posts.tags :post="$post" :campaign="$campaign"></x-posts.tags>

    @if($post->layout?->code == 'inventory')
        @include('entities.pages.inventory._grid', ['isPost' => true])
    @elseif ($post->layout?->code == 'attributes')
        <x-box class="box-entity-attributes">
            @include('entities.pages.attributes.render', ['isPost' => true])
        </x-box>
        <input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
    @elseif ($post->layout?->code == 'abilities')
        @include('entities.pages.abilities._abilities', ['isPost' => true])
    @elseif ($post->layout?->code == 'assets')
        @include('entities.pages.assets._assets', ['assets' => $entity->assets, 'isPost' => true])
    @elseif ($post->layout?->code == 'connection_map')
        @include('entities.pages.relations._map', ['option' => null, 'isPost' => true, 'mode' => 'map'])
    @elseif($post->layout?->code == 'children')
        @include('entities.components.posts.children')
    @elseif ($post->layout?->code == 'character_orgs' && $entity->isCharacter())
        @include('characters.panels.organisations', ['character' => $entity->child])
    @elseif ($post->layout?->code == 'quest_elements' && $entity->isQuest())
        @include('quests.elements._post')
    @elseif ($post->layout?->code == 'location_characters' && $entity->isLocation())
        @include('locations.panels.characters', ['init' => true])
    @elseif ($post->layout?->code == 'location_events' && $entity->isLocation())
        @include('locations.panels.events', ['init' => true])
    @elseif ($post->layout?->code == 'location_quests' && $entity->isLocation())
        @include('locations.panels.quests', ['init' => true])
    @elseif ($post->layout?->code == 'reminders')
        @include('entities.pages.reminders._post')
    @endif
</article>
