<?php
/**
 * @var \App\Models\Campaign $currentCampaign
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SidebarService $sidebar
 */
$currentCampaign = $campaign ?? CampaignLocalization::getCampaign();
$defaultIndex = ($currentCampaign && $currentCampaign->defaultToNested()) || auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
?>
@if (!empty($currentCampaign))
    @php \App\Facades\Dashboard::campaign($currentCampaign); @endphp
    @inject('sidebar', 'App\Services\SidebarService')
    @php $sidebar->campaign($currentCampaign)->prepareQuickLinks()@endphp
    <aside class="main-sidebar main-sidebar-placeholder @if(auth()->check() && $currentCampaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($currentCampaign->image) style="background-image: url({{ Img::crop(280, 210)->url($currentCampaign->image) }})" @endif>
        <section class="sidebar-campaign">
            <div class="campaign-block">
                <div class="campaign-head cursor-pointer" data-toggle="popover" title="New design" data-content="Looking for your campaigns? They are now available on the top-right when clicking the <i class='fa-solid fa-grid' aria-hidden='true'></i> icon." data-html="true" data-container="body">
                    <div class="campaign-name">
                        {!! $currentCampaign->name !!}
                    </div>

                    <div class="campaign-updated">
                        {{ __('sidebar.campaign_switcher.updated') }} {{ $currentCampaign->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </section>

        <section class="sidebar" style="height: auto">
            <ul class="sidebar-menu">

                @if (auth()->check() && $currentCampaign->userIsMember())
                <li class="quick-creator-element ab-testing-b" style="display: none" data-toggle="tooltip" title="{{ __('entities.creator.tooltip') }}">
                    <div data-url="{{ route('entity-creator.selection', ['campaign' => $campaign]) }}" data-toggle="ajax-modal" data-target="#entity-modal" class="quick-creator-button my-auto">
                        <i class="fa-solid fa-plus"></i>
                        <span>{{ __('sidebar.new-entity') }}</span>
                    </div>
                </li>
                @endif

                @foreach ($sidebar->campaign($currentCampaign)->layout() as $name => $element)
                    @if ($name === 'menu_links')
                        @includeWhen($currentCampaign->enabled('menu_links'), 'layouts.sidebars.quick-links', ['links' => $sidebar->quickLinks('menu_links')])
                        @continue
                    @endif
                    <li class="{{ (!isset($element['route']) || $element['route'] !== false ? $sidebar->active($name) : null) }} section-{{ $name }}">
                        @if ($element['route'] !== false)
                            @php
                            $route = $element['route'];
                            if (isset($element['tree'])) {
                                $route = \Illuminate\Support\Str::beforeLast($route, '.') . '.' . $defaultIndex;
                            }
                            $routeParams = ['campaign' => $currentCampaign];
                            @endphp
                            <a href="{{ route($route, $routeParams) }}">
                                <i class="{{ $element['custom_icon'] ?: $element['icon']  }}"></i>
                                {!! $element['custom_label'] ?: $element['label']  !!}
                            </a>
                        @else
                            <span>
                                <i class="{{ $element['custom_icon'] ?: $element['icon'] }}"></i>
                                {!! $element['custom_label'] ?: $element['label'] !!}
                            </span>
                        @endif
                        @if (!empty($element['children']))

                        <ul class="sidebar-submenu">
                        @foreach($element['children'] as $childName => $child)
                            <li class="{{ (!isset($child['route']) || $child['route'] !== false ? $sidebar->active($childName) : null) }} subsection section-{{ $childName }}">
                                @php
                                    $route = $child['route'];
                                    if (isset($child['tree'])) {
                                        $route = \Illuminate\Support\Str::beforeLast($route, '.') . '.' . $defaultIndex;
                                    }
                                    $routeParams = ['campaign' => $currentCampaign];
                                @endphp
                                <a href="{{ route($route, $routeParams) }}">
                                    <i class="{{ $child['custom_icon'] ?: $child['icon'] }}"></i>
                                    {!! $child['custom_label'] ?: $child['label'] !!}
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
    @if (auth()->check() && $currentCampaign->userIsMember())
        <section class="sidebar-creator">
            <span id="qq-sidebar-btn" class="absolute right-auto" data-content="{{ __('dashboards/widgets/welcome.focus.text') }}" data-placement="top"></span>
            <a href="#" data-url="{{ route('entity-creator.selection', ['campaign' => $campaign]) }}" data-toggle="ajax-modal" data-target="#entity-modal" class="quick-creator-button flex items-center justify-center px-2">
                <i class="flex-none  fa-solid fa-plus" aria-hidden="true" ></i>
                <span class="flex-grow" data-toggle="tooltip" title="{{ __('entities.creator.tooltip') }}">{{ __('sidebar.new-entity') }}</span>
                <span class="flex-none keyboard-shortcut pull-right" id="qq-kb-shortcut" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>N</code>']) !!}" data-html="true">N</span>
            </a>
        </section>
    @endif
@elseif (auth()->check() && auth()->user()->hasCampaigns())
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                @foreach (\App\Facades\UserCache::campaigns() as $userCampaign)
                    <li class="section-campaign section-campaign-{{ $userCampaign->id }}">
                        <a href="{{ route('dashboard', $userCampaign->id) }}">
                            <i class="fa-solid fa-globe"></i>
                            {!! $userCampaign->name !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif
