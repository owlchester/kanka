<?php /** @var \App\tags\Tag $tag */ ?>
<span class="rounded-xl px-3 py-1 bg-base-200 text-base-content text-xs flex items-center gap-1 {{ ($tag->hasColour() ? $tag->colourClass() . ' border-0' : '') }}">
    @if ($tag->hasIcon())
        <i class="{{ $tag->icon }}" aria-hidden="true"></i>
    @else
        {!! $tag->name !!}
    @endif
</span>
