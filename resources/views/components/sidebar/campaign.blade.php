<?php
/**
 * @var \App\Models\Campaign $campaign
 */
?>
<aside class="main-sidebar main-sidebar-placeholder absolute z-[840] h-auto min-h-full flex flex-col background-cover @if(auth()->check() && $campaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url({{ Img::crop(240, 208)->url($campaign->image) }})" @endif>

    @include('layouts.sidebars._campaign')

    <section class="sidebar grow">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0 flex flex-col gap-0.5">
            @foreach ($layout as $name => $element)
                @if ($name === 'bookmarks')
                    @if ($campaign->enabled('bookmarks'))
                        <li class="px-2 {{ $active('bookmarks') }} sidebar-quick-links sidebar-bookmarks">
                            <x-sidebar.element
                                :url="auth()->check() && auth()->user()->can('create', new App\Models\Bookmark()) ? route('bookmarks.index', $campaign) : null"
                                :icon="$element['custom_icon'] ?? $element['icon']"
                                :text="$element['custom_label'] ?? $element['label'] ?? __($element['label_key'])"
                            ></x-sidebar.element>
                            <ul class="sidebar-submenu list-none p-0 pl-3 m-0">
                                @foreach ($bookmarks('bookmarks') as $bookmark)
                                    @include('layouts.sidebars.bookmark', ['bookmark' => $bookmark])
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @continue
                @elseif (!empty($element['perm']))
                    @if (auth()->guest() || !auth()->user()->can($element['perm'], $campaign))
                        @continue
                    @endif
                @endif
                <li class="px-2 {{ (!isset($element['route']) || $element['route'] !== false ? $active($name) : null) }} section-{{ $name }}">
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
                                <li class="p-0 m-0 {{ (!isset($child['route']) || $child['route'] !== false ? $active($childName) : null) }} subsection section-{{ $childName }}">
                                    @php
                                        $route = $child['route'];
                                    @endphp
                                    <x-sidebar.element
                                        :url="route($route, $campaign)"
                                        :icon="$child['custom_icon'] ?? $child['icon']"
                                        :text="$child['custom_label'] ?? __($child['label_key'])"
                                    ></x-sidebar.element>
                                </li>
                                @includeWhen($hasBookmarks($childName), 'layouts.sidebars.bookmarks', ['links' => $bookmarks($childName)])
                            @endforeach
                        </ul>
                    @endif

                    @includeWhen($hasBookmarks($name), 'layouts.sidebars.bookmarks', ['links' => $bookmarks($name), 'css' => 'px-2'])
                </li>
            @endforeach
        </ul>
    </section>
</aside>
