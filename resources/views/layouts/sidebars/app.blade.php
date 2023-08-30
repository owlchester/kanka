<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SidebarService $sidebar
 */
?>
@if (!empty($campaign))
    @php
    $defaultIndex = $campaign->defaultToNested() || auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
    $defaultOptions = auth()->check() && auth()->user()->entityExplore === '1' ? [$campaign, 'm' => 'table'] : [$campaign];
 @endphp
    @inject('sidebar', 'App\Services\SidebarService')
    @php $sidebar->campaign($campaign)->prepareBookmarks()@endphp
    <aside class="main-sidebar main-sidebar-placeholder t-0 l-0 absolute @if(auth()->check() && $campaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url({{ Img::crop(280, 210)->url($campaign->image) }})" @endif>

        @include('layouts.sidebars._campaign')

        <section class="sidebar pb-14" style="height: auto">
            <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0">
                @foreach ($sidebar->campaign($campaign)->layout() as $name => $element)
                    @if ($name === 'bookmarks')
                        @includeWhen($campaign->enabled('bookmarks'), 'layouts.sidebars.quick-links', ['links' => $sidebar->bookmarks('bookmarks')])
                        @continue
                    @endif
                    <li class="px-2 {{ (!isset($element['route']) || $element['route'] !== false ? $sidebar->active($name) : null) }} section-{{ $name }}">
                        @if ($element['route'] !== false)
                            @php
                            $route = $element['route'];
                            if (isset($element['tree'])) {
                                $route = \Illuminate\Support\Str::beforeLast($route, '.') . '.' . $defaultIndex;
                            }
                            @endphp
                            <x-sidebar.element
                                :url="route($route, (\Illuminate\Support\Arr::get($element, 'mode') === true ? $defaultOptions : [$campaign]))"
                                :icon="$element['custom_icon'] ?? $element['icon']"
                                :text="$element['custom_label'] ?? __($element['label_key'])"
                            ></x-sidebar.element>
                        @else
                            <x-sidebar.element
                                :icon="$element['custom_icon'] ?? $element['icon']"
                                :text="$element['custom_label'] ?? __($element['label_key'])"
                            ></x-sidebar.element>
                        @endif
                        @if (!empty($element['children']))

                        <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                        @foreach($element['children'] as $childName => $child)
                            <li class="p-0 m-0 {{ (!isset($child['route']) || $child['route'] !== false ? $sidebar->active($childName) : null) }} subsection section-{{ $childName }}">
                                @php
                                    $route = $child['route'];
                                    if (isset($child['tree'])) {
                                        $route = \Illuminate\Support\Str::beforeLast($route, '.') . '.' . $defaultIndex;
                                    }
                                @endphp
                                <x-sidebar.element
                                    :url="route($route, \Illuminate\Support\Arr::get($child, 'mode') === true ? $defaultOptions : $campaign)"
                                    :icon="$child['custom_icon'] ?? $child['icon']"
                                    :text="$child['custom_label'] ?? __($child['label_key'])"
                                ></x-sidebar.element>
                            </li>
                            @includeWhen($sidebar->hasBookmarks($childName), 'layouts.sidebars._quick-links', ['links' => $sidebar->bookmarks($childName)])
                        @endforeach
                        </ul>
                        @endif

                        @includeWhen($sidebar->hasBookmarks($name), 'layouts.sidebars._quick-links', ['links' => $sidebar->bookmarks($name)])
                    </li>
                @endforeach
            </ul>

            @include('partials.ads.sidebar')
        </section>
    </aside>
@endif
