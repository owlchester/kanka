<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Tag $tag
 */
?>
<div class="tooltip-content flex flex-col gap-2 {{ implode(' ', $tagClasses) }}" >
    <div
        class="flex gap-4 items-end tooltip-header @if ($hasImage) px-4 h-32 w-full @else px-4 pt-2 @endif"
        @if ($hasImage)
            style="--tooltip-background: url('{{ Avatar::entity($entity)->size(378, 256)->thumbnail() }}')"
        @endif>
        <div class="grow entity-names flex flex-col gap-0.5 overflow-hidden">
            <div class="flex gap-1 overflow-hidden items-center text-xl ">
                <a href="{{ $entity->url() }}" class="entity-name truncate">
                    {!! $entity->name !!}
                </a>
                @if ($entity->isCharacter() && $entity->character->isDead())
                    <x-icon class="fa-regular fa-skull" tooltip :title="__('characters.hints.is_dead')" />
                @endif
            </div>


            @if ($entity->entityType->isStandard() && method_exists($entity->child, 'tooltipSubtitle'))
                <span class="entity-subtitle italic">{!! $entity->child->tooltipSubtitle() !!}</span>
            @endif
        </div>
    </div>
    @if ($tags->isNotEmpty())<div class="tooltip-tags flex flex-wrap gap-2 px-4">
        @foreach ($tags as $tag)
            @if (!$tag->entity) @continue @endif
            <a href="{{ $tag->getLink() }}" class="tooltip-tag" data-id="{{ $tag->entity->id }}" data-tag-slug="{{ $tag->slug }}" title="{{ $tag->name }}">
                @include ('tags._badge')
            </a>
        @endforeach
    </div>@endif
    @if ($campaign->premium() && $render === 'attributes')
        <iframe src="{{ route('entities.attributes-dashboard', [$campaign, $entity]) }}" class="tooltip-render w-full h-44"></iframe>
    @else
    <div class="tooltip-text flex flex-col gap-2 px-4 pb-4 overflow-auto">
        {!! $tooltip !!}
    </div>
    @endif
</div>
