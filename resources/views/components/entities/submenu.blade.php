<?php
use \Illuminate\Support\Arr;
?>
<div class="hidden lg:flex flex-col gap-5">
    @foreach ($items as $section => $menuItems)
        <x-box class="entity-menu{{ $section }}" :padding="0">
            <x-menu>
                @foreach ($menuItems as $key => $menuItem)
                    @if (Arr::has($menuItem, 'perm'))
                        @cannot($menuItem['perm'], [$entity, $campaign])
                            @continue
                        @endcannot
                    @endif
                    <x-menu.element
                        :active="!empty($active) && $active == $key"
                        :route="route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $entity->child : $entity)])"
                        :badge="$menuItem['count'] ?? 0"
                        :button="$menuItem['button'] ?? null"
                        :ajax="Arr::get($menuItem, 'ajax') ? route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $entity->child : $entity)]) : null"
                        :id="$menuItem['id'] ?? null"
                    >
                        {!! $menuItem['name'] !!}
                    </x-menu.element>

                @endforeach
            </x-menu>
        </x-box>
    @endforeach
</div>

@if (empty($printing))
    @php
        $mobileItems = collect($items)->flatMap(fn ($menuItems) => $menuItems)->filter(
            fn ($menuItem) => empty($menuItem['perm']) || \Illuminate\Support\Facades\Gate::allows($menuItem['perm'], [$entity, $campaign])
        );
        $primaryItems = $mobileItems->only(['story', 'relations']);
        $moreItems = $mobileItems->except(['story', 'relations']);
    @endphp
    <nav class="entity-mobile-navigation sticky top-[var(--entity-reader-top,3.25rem)] z-800 lg:hidden print:hidden! bg-base-100 rounded-lg shadow-sm p-2 flex flex-wrap items-center gap-1" aria-label="{{ __('Entity navigation') }}" id="sm-a">
        @foreach ($primaryItems as $key => $menuItem)
            @include('components.entities.mobile-link', ['compact' => false])
        @endforeach
        @if ($moreItems->isNotEmpty())
            <details class="entity-mobile-more">
                <summary @class(['btn2 btn-ghost min-h-11! px-1.5! gap-1! cursor-pointer list-none [&::-webkit-details-marker]:hidden', 'bg-base-200! text-base-content!' => $moreItems->has($active)]) @if ($moreItems->has($active)) aria-current="true" @endif>
                    {{ __('More') }}
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
