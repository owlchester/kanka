<?php /** @var \App\Models\MenuLink $menuLink */ ?>
@if ($menuLink->dashboard && $campaign->boosted() && $menuLink->isValidDashboard())
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($campaign) }}">
        <a href="{{ $menuLink->getRoute() }}">
            <i class="{{ $menuLink->icon() }}"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->target)
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($campaign) }}">
        <a href="{{ $menuLink->getRoute() }}">
            <i class="{{ $menuLink->icon() }}"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->type)
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($campaign) }}">
        <a href="{{ $menuLink->getRoute() }}">
            <i class="{{ $menuLink->icon() }}"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->isRandom())
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($campaign) }}">
        <a href="{{ route('quick-links.random', [$menuLink->campaign_id, $menuLink]) }}">
            <i class="{{ $menuLink->icon() }}"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@endif
