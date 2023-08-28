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
    @if (!empty($image))
        <div
            class="widget-image cover-background bg-center aspect-video rounded-t "
            style="background-image: url('{{ $image }}');"
        ></div>
    @endif
    <a href="{{ $entity->child->getLink() }}" class="flex gap-1 text-xl p-4 pb-0">
        @if ($entity->is_private)
            <x-icon class="fa-solid fa-lock" :title="__('crud.is_private')" :tooltip="true" />
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
