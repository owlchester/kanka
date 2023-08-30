<?php /** @var \App\Models\Bookmark $bookmark */ ?>
@if ($bookmark->dashboard && $campaign->boosted() && $bookmark->isValidDashboard())
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->icon()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@elseif ($bookmark->target)
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->icon()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@elseif ($bookmark->type)
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->icon()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@elseif ($bookmark->isRandom())
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $sidebar->activeBookmark($bookmark) }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.element
                :url="$bookmark->getRoute()"
                :icon="$bookmark->icon()"
                :text="$bookmark->name"
        ></x-sidebar.element>
    </li>
@endif
