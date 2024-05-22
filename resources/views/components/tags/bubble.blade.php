<a href="{{ $tag->getLink() }}" class="{{ $css }}" data-title="{{ $tag->name }}" data-toggle="tooltip" data-tag-id="{{ $tag->id }}" data-tag-slug="{{ $tag->slug }}">
    {{ ucfirst(mb_substr($tag->slug, 0, 1)) }}
</a>
