@php
    $desktopSections = collect($items)->map(
        fn ($menuItems) => collect($menuItems)->filter(
            fn ($menuItem) => empty($menuItem['perm']) || \Illuminate\Support\Facades\Gate::allows($menuItem['perm'], [$entity, $campaign])
        )
    )->filter(fn ($menuItems) => $menuItems->isNotEmpty());
@endphp

<nav class="entity-menu-section entity-desktop-navigation hidden lg:flex items-center rounded-xl p-1.5 overflow-x-auto print:hidden!" aria-label="{{ __('crud.navigation.entity') }}">
    <ul class="list-none menu entity-menu flex flex-nowrap items-center gap-1 m-0 p-0 text-sm">
        @foreach ($desktopSections as $sectionItems)
            @if (!$loop->first)
                <li class="entity-menu-divider w-px h-4 bg-base-300 mx-1 shrink-0" aria-hidden="true"></li>
            @endif
            @foreach ($sectionItems as $key => $menuItem)
                @php
                    $desktopUrl = route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $entity->child : $entity)]);
                    $isActive = !empty($active) && $active == $key;
                    $ajax = \Illuminate\Support\Arr::get($menuItem, 'ajax') ? $desktopUrl : null;
                    $itemId = $menuItem['id'] ?? null;
                    $badge = $menuItem['count'] ?? 0;
                @endphp
                <li @class(['relative flex items-center shrink-0 rounded-lg transition-colors duration-150 overflow-hidden', 'active' => $isActive])>
                    <a href="{{ $desktopUrl }}"
                       class="flex items-center gap-1.5 py-1.5 px-2.5 whitespace-nowrap select-none transition-all duration-150 cursor-pointer text-inherit overflow-hidden"
                       @if ($isActive) aria-current="page" @endif
                       @if (!empty($ajax)) data-toggle="dialog" data-url="{{ $ajax }}" @endif
                       @if (!empty($itemId)) id="{{ $itemId }}" @endif>
                        <span>{!! $menuItem['name'] !!}</span>
                        @if ($badge > 0)
                            <span class="text-xs text-neutral-content tabular-nums opacity-75">
                                {{ \Illuminate\Support\Number::format($badge) }}
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        @endforeach
    </ul>
</nav>

@if (empty($printing))
    @php
        $mobileItems = collect($items)->flatMap(fn ($menuItems) => $menuItems)->filter(
            fn ($menuItem) => empty($menuItem['perm']) || \Illuminate\Support\Facades\Gate::allows($menuItem['perm'], [$entity, $campaign])
        );
        $primaryItems = $mobileItems->only(['story', 'relations']);
        $moreItems = $mobileItems->except(['story', 'relations']);
    @endphp
    <nav class="entity-mobile-navigation sticky top-[var(--entity-reader-top,3.25rem)] z-800 lg:hidden print:hidden! bg-base-100 rounded-lg shadow-sm p-2 flex flex-wrap items-center gap-1" aria-label="{{ __('crud.navigation.entity') }}" id="sm-a">
        @foreach ($primaryItems as $key => $menuItem)
            @include('components.entities.mobile-link', ['compact' => false])
        @endforeach
        @if ($moreItems->isNotEmpty())
            <details class="entity-mobile-more">
                <summary @class(['btn2 btn-ghost min-h-11! px-1.5! gap-1! cursor-pointer list-none [&::-webkit-details-marker]:hidden', 'bg-base-200! text-base-content!' => $moreItems->has($active)]) @if ($moreItems->has($active)) aria-current="true" @endif>
                    {{ __('crud.tabs.more') }}
                    <x-icon class="fa-regular fa-chevron-down" />
                </summary>
                <div class="entity-mobile-more-links absolute left-0 top-full w-full max-w-88 mt-2 overflow-y-auto wrap-anywhere bg-base-100 rounded-lg shadow-lg border border-base-300 p-2 flex flex-col gap-0.5">
                    @foreach ($moreItems as $key => $menuItem)
                        @include('components.entities.mobile-link', ['compact' => true])
                    @endforeach
                </div>
            </details>
        @endif
        @if ($active === 'story')
            <a href="#entity-details-{{ $entity->id }}" class="btn2 btn-ghost min-h-11! px-1.5! gap-1! ml-auto [&[hidden]]:hidden!" data-reader-details-link>{{ __('Details') }}</a>
        @endif
        <div class="js-entity-reader contents"
             data-labels="{{ json_encode([
                 'details' => __('Details'),
                 'close' => __('Close dialog'),
                 'jump' => __('Jump to article'),
                 'onPage' => __('On this page - jump to article'),
                 'story' => __('crud.tabs.overview'),
             ]) }}"
             data-entity-id="{{ $entity->id }}"></div>
    </nav>
@endif
