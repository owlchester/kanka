<?php /** @var \App\Models\Bookmark $bookmark */ ?>
@if ($bookmark->dashboard && $campaign->boosted() && $bookmark->isValidDashboard())
    <li class="{{ $css ?? null }} p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.bookmark :bookmark="$bookmark" :campaign="$campaign" />
    </li>
@elseif ($bookmark->target)
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.bookmark :bookmark="$bookmark" :campaign="$campaign" />
    </li>
@elseif ($bookmark->entityType)
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $bookmark->customClass($campaign) }} {{ $bookmark->activeModule($campaign, $entityType ?? $entity ?? null) }}">
        <x-sidebar.bookmark :bookmark="$bookmark" :campaign="$campaign" />
    </li>
@elseif ($bookmark->isRandom())
    <li class="p-0 m-0 subsection sidebar-bookmark sidebar-bookmark-{{ $bookmark->position }} {{ $bookmark->customClass($campaign) }}">
        <x-sidebar.bookmark :bookmark="$bookmark" :campaign="$campaign" />
    </li>
@endif
