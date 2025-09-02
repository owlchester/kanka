<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
<div class="flex gap-1 flex-wrap">

@if ($model instanceof \App\Models\MiscModel)
    @foreach ($model->entity->visibleTags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@elseif ($model instanceof \App\Models\Entity || $model instanceof \App\Models\Post)
    @foreach ($model->visibleTags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@elseif ($model instanceof \App\Models\CharacterRace || $model instanceof \App\Models\CharacterFamily)
    @foreach ($model->character->entity->visibleTags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@else
    @foreach ($model->tags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
@endif
</div>
