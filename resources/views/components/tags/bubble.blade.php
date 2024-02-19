<a href="{{ $tag->getLink() }}" class="{{ $css }}" title="{{ $tag->name }}" data-tag-id="{{ $tag->id }}" data-tag-slug="{{ $tag->slug }}">
    {{ ucfirst(mb_substr($tag->slug, 0, 1)) }}
</a>
