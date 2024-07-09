<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
<div class="flex gap-1 flex-wrap">

@if ($model instanceof \App\Models\MiscModel)
    @foreach ($model->entity->tags as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" />
    @endforeach
@elseif ($model instanceof \App\Models\Entity)
    @foreach ($model->tags as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" />
    @endforeach
@elseif ($model instanceof \App\Models\CharacterRace || $model instanceof \App\Models\CharacterFamily)
    @foreach ($model->character->entity->tags as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" />
    @endforeach
@else
    @foreach ($model->tags() as $tag)
        @if (!$tag->entity) @continue @endif
        <x-tags.bubble :tag="$tag" />
    @endforeach
@endif
</div>
