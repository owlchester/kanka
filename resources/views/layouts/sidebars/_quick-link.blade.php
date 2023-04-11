<?php /** @var \App\Models\MenuLink $menuLink */ ?>
@if ($menuLink->dashboard && $currentCampaign->boosted() && $menuLink->isValidDashboard())
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ $menuLink->getRoute() }}">
            <i class="{{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->target)
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ $menuLink->getRoute() }}">
            <i class="{{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->type)
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ $menuLink->getRoute() }}">
            <i class="{{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->isRandom())
    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ route('menu_links.random', $menuLink) }}">
            <i class="{{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@endif
