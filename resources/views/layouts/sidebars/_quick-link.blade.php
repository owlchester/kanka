<?php /** @var \App\Models\Bookmark $bookmark */ ?>
@if ($bookmark->dashboard && $campaign->boosted() && $bookmark->isValidDashboard())
    <li class="{{ $css ?? null }} p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->iconClass()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@elseif ($bookmark->target)
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->iconClass()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@elseif ($bookmark->entityType)
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }} {{ $bookmark->activeModule($campaign, $entityType ?? $entity ?? null) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->iconClass()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@elseif ($bookmark->isRandom())
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->iconClass()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@endif
