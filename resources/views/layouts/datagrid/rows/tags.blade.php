<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@php $target = empty($with) ? $model : data_get($model, $with) @endphp

<div class="flex gap-1 flex-wrap">

@if ($target instanceof \App\Models\MiscModel)
    @foreach ($target->entity->visibleTags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@elseif ($target instanceof \App\Models\Entity || $model instanceof \App\Models\Post)
    @foreach ($target->visibleTags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@elseif ($target instanceof \App\Models\CharacterRace || $target instanceof \App\Models\CharacterFamily)
    @foreach ($target->character->entity->visibleTags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@else
    @foreach ($target->tags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@endif
</div>
