<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Tag $tag
 */
?>
<div class="tooltip-content flex flex-col gap-2 p-1 {{ implode(' ', $tagClasses) }}">
    <div class="flex gap-2 items-center mb-1">
        @if ($campaign->boosted() && $campaign->tooltip_image && Avatar::entity($entity)->hasImage())
        <div class="flex-none">
                <div class="rounded-full w-10 h-10 cover-background" style="background-image: url('{{ Avatar::entity($entity)->size(40)->thumbnail() }}');"></div>
        </div>
        @endif
        <div class="grow entity-names">
            <a href="{{ $entity->url() }}" class="entity-name text-xl block">
                {!! $entity->name !!}
            </a>
            @if (!$entity->entityType->isSpecial() && method_exists($entity->child, 'tooltipSubtitle'))
                <span class="entity-subtitle text-base block">{!! $entity->child->tooltipSubtitle() !!}</span>
            @endif
        </div>
    </div>
    @if ($tags->isNotEmpty())<div class="tooltip-tags flex flex-wrap gap-2">
        @foreach ($tags as $tag)
            @if (!$tag->entity) @continue @endif
            <a href="{{ $tag->getLink() }}" class="tooltip-tag" data-id="{{ $tag->entity->id }}" data-tag-slug="{{ $tag->slug }}" title="{{ $tag->name }}">
                @include ('tags._badge')
            </a>
        @endforeach
    </div>@endif
    @if ($campaign->premium() && $render === 'attributes')
        <iframe src="{{ route('entities.attributes-dashboard', [$campaign, $entity]) }}" class="tooltip-render w-full h-44" />
    @else
    <div class="tooltip-text text-sm">
        {!! $entity->ajaxTooltip() !!}
    </div>
    @endif
</div>
