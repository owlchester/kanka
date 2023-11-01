<a href="{{ $tag->getLink() }}" class="{{ $css }}" title="{{ $tag->name }}">
    {{ ucfirst(mb_substr($tag->slug, 0, 1)) }}
</a>
