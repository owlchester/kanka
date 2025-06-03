<?php /** @var \App\Models\Tag $tag */ ?>
<a
    href="{{ $tag->getLink() }}"
    class="{{ $css }}"
    data-toggle="tooltip-ajax"
    data-url="{{ route('entities.tooltip', [$campaign, $tag->entity->id]) }}"
    data-tag-id="{{ $tag->id }}"
    data-tag-slug="{{ $tag->slug }}"
    data-entity-id="{{ $tag->entity->id }}">
    {{ $tag->shortName() }}
</a>
