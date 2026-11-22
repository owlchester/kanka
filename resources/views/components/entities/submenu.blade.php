@php
    $permittedItems = collect($items)->flatMap(fn ($menuItems) => $menuItems)->filter(
        fn ($menuItem) => empty($menuItem['perm']) || \Illuminate\Support\Facades\Gate::allows($menuItem['perm'], [$entity, $campaign])
    );
    $secondaryKeys = ['abilities', 'reminders', 'inventory', 'assets', 'mentions', 'story_reorder', 'permissions'];
    $desktopPrimary = $permittedItems->except($secondaryKeys);
    $desktopSecondary = $permittedItems->only($secondaryKeys);

    if (!empty($active) && $desktopSecondary->has($active)) {
        $desktopPrimary = $desktopPrimary->put($active, $desktopSecondary->get($active));
        $desktopSecondary = $desktopSecondary->forget($active);
    }
@endphp

<nav class="entity-menu-section entity-desktop-navigation hidden lg:flex items-center gap-1 rounded-xl p-1.5 print:hidden!" aria-label="{{ __('crud.navigation.entity') }}">
    <ul class="list-none menu entity-menu flex flex-wrap items-center gap-1 m-0 p-0 text-sm grow">
        @foreach ($desktopPrimary as $key => $menuItem)
            @php
                $desktopUrl = route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $entity->child : $entity)]);
                $isActive = !empty($active) && $active == $key;
                $ajax = \Illuminate\Support\Arr::get($menuItem, 'ajax') ? $desktopUrl : null;
                $itemId = $menuItem['id'] ?? null;
                $badge = $menuItem['count'] ?? 0;
            @endphp
            <li @class(['relative flex items-center rounded-lg transition-colors duration-150 overflow-hidden', 'active' => $isActive])>
                <a href="{{ $desktopUrl }}"
                   class="flex items-center gap-1.5 py-1.5 px-2.5 select-none transition-all duration-150 cursor-pointer text-inherit overflow-hidden"
                   @if ($isActive) aria-current="page" @endif
                   @if (!empty($ajax)) data-toggle="dialog" data-url="{{ $ajax }}" @endif
                   @if (!empty($itemId)) id="{{ $itemId }}" @endif>
                    <span class="truncate">{!! $menuItem['name'] !!}</span>
                    @if ($badge > 0)
                        <span class="text-xs text-neutral-content tabular-nums opacity-75">
                            {{ \Illuminate\Support\Number::format($badge) }}
                        </span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    @if ($desktopSecondary->isNotEmpty())
        <details class="entity-desktop-more relative shrink-0">
            <summary @class([
                'flex items-center gap-1.5 py-1.5 px-2.5 rounded-lg text-sm cursor-pointer select-none list-none [&::-webkit-details-marker]:hidden transition-colors duration-150',
                'bg-base-200 font-medium text-base-content' => $desktopSecondary->has($active),
                'text-base-content/75 hover:bg-base-200/60 hover:text-base-content' => !$desktopSecondary->has($active),
            ]) @if ($desktopSecondary->has($active)) aria-current="true" @endif>
                <span>{{ __('crud.tabs.more') }}</span>
                <x-icon class="fa-regular fa-chevron-down text-xs opacity-70" />
            </summary>
            <ul class="list-none menu entity-menu absolute right-0 top-full mt-2 z-820 min-w-48 bg-base-100 rounded-xl shadow-lg p-1.5 m-0 flex flex-col gap-0.5 text-sm">
                @foreach ($desktopSecondary as $key => $menuItem)
                    @php
                        $secondaryUrl = route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $entity->child : $entity)]);
                        $isSecondaryActive = !empty($active) && $active == $key;
                        $secondaryAjax = \Illuminate\Support\Arr::get($menuItem, 'ajax') ? $secondaryUrl : null;
                        $secondaryId = $menuItem['id'] ?? null;
                        $secondaryBadge = $menuItem['count'] ?? 0;
                    @endphp
                    <li @class(['relative w-full flex items-center rounded-lg transition-colors duration-150 overflow-hidden', 'active' => $isSecondaryActive])>
                        <a href="{{ $secondaryUrl }}"
                           class="flex justify-between items-center grow select-none gap-2 py-1.5 px-2.5 transition-all duration-150 cursor-pointer text-inherit overflow-hidden"
                           @if ($isSecondaryActive) aria-current="page" @endif
                           @if (!empty($secondaryAjax)) data-toggle="dialog" data-url="{{ $secondaryAjax }}" @endif
                           @if (!empty($secondaryId)) id="{{ $secondaryId }}" @endif>
                            <span class="truncate">{!! $menuItem['name'] !!}</span>
                            @if ($secondaryBadge > 0)
                                <span class="text-xs text-neutral-content tabular-nums opacity-75">
                                    {{ \Illuminate\Support\Number::format($secondaryBadge) }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </details>
    @endif
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
