@if ($entry['kind'] === 'bookmark')
    <li class="px-2 sidebar-v2-item sidebar-bookmark {{ $entry['bookmark']->customClass() }} {{ $entry['bookmark']->activeModule($campaign, $entityType ?? $entity ?? null) }}" data-sidebar-item="{{ $entry['id'] }}">
        <x-sidebar.bookmark :bookmark="$entry['bookmark']" :campaign="$campaign" />
    </li>
@else
    <li class="px-2 sidebar-v2-item {{ $activeV2($entry) }}" data-sidebar-item="{{ $entry['id'] }}">
        <x-sidebar.element :url="$entry['url']" :icon="$entry['icon']" :text="$entry['label']" />
    </li>
@endif
