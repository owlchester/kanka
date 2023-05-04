<?php /** @var \App\Models\MenuLink $menuLink */ ?>
@if ($menuLink->dashboard && $currentCampaign->boosted() && $menuLink->isValidDashboard())
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <x-sidebar.element
            :url="$menuLink->getRoute()"
            :icon="$menuLink->icon()"
            :text="$menuLink->name"
        ></x-sidebar.element>
    </li>
@elseif ($menuLink->target)
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <x-sidebar.element
            :url="$menuLink->getRoute()"
            :icon="$menuLink->icon()"
            :text="$menuLink->name"
        ></x-sidebar.element>
    </li>
@elseif ($menuLink->type)
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <x-sidebar.element
            :url="$menuLink->getRoute()"
            :icon="$menuLink->icon()"
            :text="$menuLink->name"
        ></x-sidebar.element>
    </li>
@elseif ($menuLink->isRandom())
    <li class="p-0 m-0 subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }} {{ $menuLink->customClass($currentCampaign) }}">
        <x-sidebar.element
            :url="$menuLink->getRoute()"
            :icon="$menuLink->icon()"
            :text="$menuLink->name"
        ></x-sidebar.element>
    </li>
@endif
