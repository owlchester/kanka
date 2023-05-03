<?php
/**
 * @var \App\Models\Campaign $currentCampaign
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SidebarService $sidebar
 */
$currentCampaign = CampaignLocalization::getCampaign();
$defaultIndex = ($currentCampaign && $currentCampaign->defaultToNested()) || auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
$defaultOptions = auth()->check() && auth()->user()->entityExplore === '1' ? ['m' => 'table'] : null;
?>
@if (!empty($currentCampaign))
    @php \App\Facades\Dashboard::campaign($currentCampaign); @endphp
    @inject('sidebar', 'App\Services\SidebarService')
    @php $sidebar->campaign($currentCampaign)->prepareQuickLinks()@endphp
    <aside class="main-sidebar main-sidebar-placeholder t-0 l-0 absolute @if(auth()->check() && $currentCampaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($currentCampaign->image) style="--sidebar-placeholder: url({{ Img::crop(280, 210)->url($currentCampaign->image) }})" @endif>
        <section class="sidebar-campaign h-40 overflow-hidden">
            <div class="campaign-block h-32 px-4 pt-24">
                <div class="campaign-head">
                    <div class="campaign-name truncate text-xl">
                        {!! $currentCampaign->name !!}
                    </div>

                    <div class="campaign-updated text-xs text-gray-300 truncate">
                        {{ __('sidebar.campaign_switcher.updated') }} {{ $currentCampaign->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </section>

        <section class="sidebar" style="height: auto">
            <ul class="sidebar-menu overflow-hidden whitespace-no-wrap m-0 p-0 list-none mb-14">
                @foreach ($sidebar->campaign($currentCampaign)->layout() as $name => $element)
                    @if ($name === 'menu_links')
                        @includeWhen($currentCampaign->enabled('menu_links'), 'layouts.sidebars.quick-links', ['links' => $sidebar->quickLinks('menu_links')])
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
                            <a href="{{ route($route, (\Illuminate\Support\Arr::get($element, 'mode') === true ? $defaultOptions : [])) }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                <i class="w-6 flex-shrink-0 text-base {{ $element['custom_icon'] ?? $element['icon']  }}" aria-hidden="true"></i>
                                <span class="inline-block truncate">{!! $element['custom_label'] ?? __($element['label_key']) !!}</span>
                            </a>
                        @else
                            <div class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                <i class="w-6 flex-shrink-0 text-base {{ $element['custom_icon'] ?? $element['icon'] }}" aria-hidden="true"></i>
                                <span class="inline-block truncate">{!! $element['custom_label'] ?? __($element['label_key']) !!}</span>
                            </div>
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
                                <a href="{{ route($route, \Illuminate\Support\Arr::get($child, 'mode') === true ? $defaultOptions : []) }}" class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
                                    <i class="w-6 flex-shrink-0 text-base {{ $child['custom_icon'] ?? $child['icon'] }}" aria-hidden="true"></i>
                                    <span class="inline-block truncate">{!! $child['custom_label'] ?? __($child['label_key']) !!}</span>
                                </a>
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
