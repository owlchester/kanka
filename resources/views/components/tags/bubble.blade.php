<?php /** @var \App\Models\Tag $tag */ ?>
<a
    href="{{ $tag->getLink() }}"
    class="{{ $css }}"
    @if($inlineStyle) style="{{ $inlineStyle }}" @endif
    data-toggle="tooltip-ajax"
    data-url="{{ route('entities.tooltip', [$campaign, $tag->entity->id]) }}"
    data-tag-id="{{ $tag->id }}"
    data-tag-slug="{{ $tag->slug }}"
    data-entity-id="{{ $tag->entity->id }}">
    @if ($tag->hasIcon())
        <i class="{{ $tag->icon }}" aria-hidden="true"></i>
    @else
        {{ $tag->shortName() }}
    @endif
</a>
