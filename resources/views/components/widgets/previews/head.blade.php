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
            class="widget-image cover-background bg-center aspect-video "
            >
            <picture class="entity-image-wide">
                <source srcset="{{ $images['wide_xl'] }}" media="(min-width: 768px)" />
                <img src="{{ $images['wide_sm'] }}" class="w-full entity-picture-wide rounded-t-lg" alt="{{ $entity->name }}" />
            </picture>
            <picture class="entity-image-square hidden">
                <source srcset="{{ $images['square_xl'] }}" media="(min-width: 768px)" />
                <img src="{{ $images['square_sm'] }}" class="w-full entity-picture-square rounded-t-lg" alt="{{ $entity->name }}" />
            </picture>
        </a>
    @endif
    <a href="{{ $entity->url() }}" class="flex gap-1 text-lg p-4 pb-0 text-link">
        @if ($entity->is_private)
            <x-icon class="lock" :title="__('crud.is_private')" tooltip />
        @endif
        <span class="grow truncate">
        @if(!empty($customName))
            {{ $customName }}
        @elseif (!empty($widget->conf('text')))
            {{ $widget->conf('text') }}
        @else
            {!! $entity->name !!}
        @endif
        </span>

        @if ($entity->status_id)
            @php
                $widgetStatus = \Illuminate\Support\Facades\DB::table('category_statuses')->find($entity->status_id);
            @endphp
            @if ($widgetStatus && $widgetStatus->icon)
                <x-icon class="fa-regular {{ $widgetStatus->icon }}" tooltip :title="__('entities/statuses.' . $entity->entityType->code . '.' . $widgetStatus->key)" />
            @endif
        @endif
        {!! $slot !!}
    </a>
</div>
