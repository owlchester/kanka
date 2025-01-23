<?php /** @var \App\tags\Tag $tag */ ?>
<span class="badge {{ ($tag->hasColour() ? $tag->colourClass() . 'py-1 rounded-sm' : 'color-tag rounded-sm px-2 py-1') }}">
    {!! $tag->name !!}
</span>
