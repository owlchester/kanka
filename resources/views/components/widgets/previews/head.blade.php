@php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */
@endphp
<div
    class="widget-header"
>
    @if (!empty($images['wide_xl']))
        <a href="{{ $entity->url() }}"
            class="widget-image cover-background bg-center aspect-video rounded-t "
            >
            <picture class="entity-image-wide">
                <source srcset="{{ $images['wide_xl'] }}" media="(min-width: 768px)" />
                <img src="{{ $images['wide_sm'] }}" class="w-full entity-picture-wide" alt="{{ $entity->name }}" />
            </picture>
            <picture class="entity-image-square hidden">
                <source srcset="{{ $images['square_xl'] }}" media="(min-width: 768px)" />
                <img src="{{ $images['square_sm'] }}" class="w-full entity-picture-square" alt="{{ $entity->name }}" />
            </picture>
        </a>
    @endif
    <a href="{{ $entity->url() }}" class="flex gap-1 text-xl p-4 pb-0">
        @if ($entity->is_private)
            <x-icon class="lock" :title="__('crud.is_private')" tooltip />
        @endif
        <span class="grow">
        @if(!empty($customName))
            {{ $customName }}
        @elseif (!empty($widget->conf('text')))
            {{ $widget->conf('text') }}
        @else
            {!! $entity->name !!}
        @endif
        </span>

        {!! $slot !!}
    </a>
</div>
