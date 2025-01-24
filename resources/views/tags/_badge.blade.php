<?php /** @var \App\tags\Tag $tag */ ?>
<span class="rounded-xl px-3 py-1 bg-base-100 text-base-content text-xs flex items-center {{ ($tag->hasColour() ? $tag->colourClass() . ' border-0' : '') }}">
    {!! $tag->name !!}
</span>
