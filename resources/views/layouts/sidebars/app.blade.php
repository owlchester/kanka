<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SidebarService $sidebar
 */
?>
@if (!empty($campaign))
    @inject('sidebar', 'App\Services\SidebarService')
    @php $sidebar->campaign($campaign)->prepareBookmarks()@endphp
    <aside class="main-sidebar main-sidebar-placeholder absolute z-20 h-auto min-h-full flex flex-col background-cover @if(auth()->check() && $campaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url({{ Img::crop(240, 208)->url($campaign->image) }})" @endif>

        @include('layouts.sidebars._campaign')

        <section class="sidebar grow">
            <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0 flex flex-col gap-0.5">
                @foreach ($sidebar->campaign($campaign)->layout() as $name => $element)
                    @if ($name === 'bookmarks')
                        @includeWhen($campaign->enabled('bookmarks'), 'layouts.sidebars.quick-links', ['links' => $sidebar->bookmarks('bookmarks')])
                        @continue
                    @elseif (!empty($element['perm']))
                        @if (auth()->guest() || !auth()->user()->can($element['perm'], $campaign))
                            @continue
                        @endif
                    @endif
                    <li class="px-2 {{ (!isset($element['route']) || $element['route'] !== false ? $sidebar->active($name) : null) }} section-{{ $name }}">
                        @if ($element['route'] !== false)
                            @php
                            $route = $element['route'];
                            @endphp
                            <x-sidebar.element
                                :url="route($route, [$campaign])"
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

                        <ul class="sidebar-submenu list-none p-0 pl-3 m-0 flex flex-col gap-0.5">
                        @foreach($element['children'] as $childName => $child)
                            <li class="p-0 m-0 {{ (!isset($child['route']) || $child['route'] !== false ? $sidebar->active($childName) : null) }} subsection section-{{ $childName }}">
                                @php
                                    $route = $child['route'];
                                @endphp
                                <x-sidebar.element
                                    :url="route($route, $campaign)"
                                    :icon="$child['custom_icon'] ?? $child['icon']"
                                    :text="$child['custom_label'] ?? __($child['label_key'])"
                                ></x-sidebar.element>
                            </li>
                            @includeWhen($sidebar->hasBookmarks($childName), 'layouts.sidebars._quick-links', ['links' => $sidebar->bookmarks($childName)])
                        @endforeach
                        </ul>
                        @endif

                        @includeWhen($sidebar->hasBookmarks($name), 'layouts.sidebars._quick-links', ['links' => $sidebar->bookmarks($name), 'css' => 'px-2'])
                    </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif
