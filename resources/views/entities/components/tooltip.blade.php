<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Tag $tag
 */
?>
<div class="tooltip-content p-1 {{ implode(' ', $tagClasses) }}">
    <div class="flex gap-2 items-center mb-1">
        @if ($campaign->boosted() && $campaign->tooltip_image && $entity->hasImage($campaign->superboosted()))
        <div class="flex-0">
            <div class="entity-image w-15 h-15" style="background-image: url('{{ $entity->avatar(true) }} ');"></div>
        </div>
        @endif
        <div class="grow entity-names">
            <span class="entity-name text-xl block">{!! $entity->child->name !!}</span>
            @if (method_exists($entity->child, 'tooltipSubtitle'))
                <span class="entity-subtitle text-base block">{!! $entity->child->tooltipSubtitle() !!}</span>
            @endif
        </div>
    </div>
    @if ($tags->isNotEmpty())<div class="tooltip-tags mb-1">
        @foreach ($tags as $tag)
            @if (!$tag->entity) @continue @endif
            <span class="tooltip-tag inline-block" data-id="{{ $tag->entity->id }}" data-tag-slug="{{ $tag->slug }}">
                {!! $tag->html() !!}
            </span>
        @endforeach
    </div>@endif
    <div class="tooltip-text text-sm">
    {!! $entity->ajaxTooltip() !!}
    </div>
</div>
