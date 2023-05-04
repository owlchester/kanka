<?php /** @var \App\Models\MenuLink $menuLink */ ?>
@if ($menuLink->dashboard && $currentCampaign->boosted() && $menuLink->isValidDashboard())
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ $menuLink->getRoute() }}" class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
            <i class="w-6 flex-shrink-0 text-base {{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->target)
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ $menuLink->getRoute() }}" class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
            <i class="w-6 flex-shrink-0 text-base {{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->type)
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ $menuLink->getRoute() }}" class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
            <i class="w-6 flex-shrink-0 text-base {{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@elseif ($menuLink->isRandom())
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <a href="{{ route('menu_links.random', $menuLink) }}" class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
            <i class="w-6 flex-shrink-0 text-base {{ $menuLink->icon() }}" aria-hidden="true"></i>
            {{ $menuLink->name }}
        </a>
    </li>
@endif
