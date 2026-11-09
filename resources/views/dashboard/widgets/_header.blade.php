<?php
/**
* @var \App\Models\CampaignDashboardWidget $widget
*/
?>
{{-- Check if the header is linked to an entity
     and if the user has read permissions on it --}}
@if ($widget->target instanceof \App\Models\Entity && !$widget->target->isMissingChild())
    <a href="{{ $widget->target->url() }}">
        <{{ $widget->customSize() }} class="widget-header-text text-center {{ $widget->cardImage ? 'overflow-hidden rounded-lg bg-box' : 'my-4' }} {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
            @if ($widget->cardImage)<img class="block w-full aspect-[16/7] object-cover" src="{{ $widget->cardImage->getUrl(800, 350) }}" alt=""><span class="block px-3 py-3">@endif
            {{ $widget->conf('text') }}
            @if ($widget->cardImage)</span>@endif
        </{{ $widget->customSize() }}>
    </a>
@elseif ($widget->target instanceof \App\Models\CampaignDashboard)
    <a href="{{ route('dashboard', [$campaign, 'dashboard' => $widget->target->id]) }}">
        <{{ $widget->customSize() }} class="widget-header-text text-center my-4 {{ $widget->cardImage ? 'overflow-hidden rounded-lg bg-box' : '' }} {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
            @if ($widget->cardImage)<img class="block w-full aspect-[16/7] object-cover" src="{{ $widget->cardImage->getUrl(800, 350) }}" alt=""><span class="block px-3 py-3">@endif
            {{ $widget->conf('text') }}
            @if ($widget->cardImage)</span>@endif
        </{{ $widget->customSize() }}>
    </a>
@else
    <{{ $widget->customSize() }} class="widget-header-text text-center my-4 {{ $widget->cardImage ? 'overflow-hidden rounded-lg bg-box' : '' }} {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
        @if ($widget->cardImage)<img class="block w-full aspect-[16/7] object-cover" src="{{ $widget->cardImage->getUrl(800, 350) }}" alt=""><span class="block px-3 py-3">@endif
        {{ $widget->conf('text') }}
        @if ($widget->cardImage)</span>@endif
    </{{ $widget->customSize() }}>
@endif
