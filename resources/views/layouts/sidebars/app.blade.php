<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SidebarService $sidebar
 */
$defaultIndex = ($campaign && $campaign->defaultToNested()) || auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
$defaultOptions = auth()->check() && auth()->user()->entityExplore === '1' ? [$campaign, 'm' => 'table'] : [$campaign];
?>
@if (!empty($campaign))
    @php \App\Facades\Dashboard::campaign($campaign); @endphp
    @inject('sidebar', 'App\Services\SidebarService')
    @php $sidebar->campaign($campaign)->prepareQuickLinks()@endphp
    <aside class="main-sidebar main-sidebar-placeholder t-0 l-0 absolute @if(auth()->check() && $campaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url({{ Img::crop(280, 210)->url($campaign->image) }})" @endif>
        <section class="sidebar-campaign h-40 overflow-hidden">
            <div class="campaign-block h-32 px-4 pt-24">
                <div class="campaign-head">
                    <div class="campaign-name truncate text-xl">
                        {!! $campaign->name !!}
                    </div>

                    <div class="campaign-updated text-xs truncate">
                        {{ __('sidebar.campaign_switcher.updated') }} {{ $campaign->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </section>

        <section class="sidebar pb-14" style="height: auto">
            <ul class="sidebar-menu overflow-hidden whitespace-no-wrap m-0 p-0 list-none">
                @foreach ($sidebar->campaign($campaign)->layout() as $name => $element)
                    @if ($name === 'menu_links')
                        @includeWhen($campaign->enabled('menu_links'), 'layouts.sidebars.quick-links', ['links' => $sidebar->quickLinks('menu_links')])
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
                            @includeWhen($sidebar->hasQuickLinks($childName), 'layouts.sidebars._quick-links', ['links' => $sidebar->quickLinks($childName)])
                        @endforeach
                        </ul>
                        @endif

                        @includeWhen($sidebar->hasQuickLinks($name), 'layouts.sidebars._quick-links', ['links' => $sidebar->quickLinks($name)])
                    </li>
                @endforeach
            </ul>

            @include('partials.ads.sidebar')
        </section>
    </aside>
@endif
