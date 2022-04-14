<?php
/**
 * @var \App\Models\Campaign $currentCampaign
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SidebarService $sidebar
 */
$currentCampaign = CampaignLocalization::getCampaign();
$defaultIndex = ($currentCampaign && $currentCampaign->defaultToNested()) || auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
?>
@if (!empty($currentCampaign))
    @php \App\Facades\Dashboard::campaign($currentCampaign); @endphp
    @inject('sidebar', 'App\Services\SidebarService')
    <aside class="main-sidebar main-sidebar-placeholder @if(auth()->check() && $currentCampaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($currentCampaign->image) style="background-image: url({{ Img::crop(280, 210)->url($currentCampaign->image) }})" @endif>
        <section class="sidebar-campaign">
            <div class="campaign-block">
                <div class="campaign-head">
                    <div class="campaign-name">
                        @if(auth()->check())<i class="fa fa-caret-down pull-right"></i>@endif
                        {!! $currentCampaign->name !!}
                    </div>

                    <div class="campaign-updated">
                        {{ __('sidebar.campaign_switcher.updated') }} {{ $currentCampaign->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </section>

        @includeWhen(auth()->check(), 'layouts.sidebars.campaign-switcher')

        <section class="sidebar" style="height: auto">
            <ul class="sidebar-menu">

                @foreach ($sidebar->campaign($currentCampaign)->layout() as $name => $element)
                    @if ($name === 'menu_links')
                        @includeWhen($currentCampaign->enabled('menu_links'), 'layouts.sidebars.quick-links', $element)
                        @continue
                    @endif

                    <li class="{{ (!isset($element['route']) || $element['route'] !== false ? $sidebar->active($name) : null) }} section-{{ $name }}">
                        @if ($element['route'] !== false)
                            @php
                            $route = $element['route'];
                            if (isset($element['tree'])) {
                                $route = \Illuminate\Support\Str::beforeLast($route, '.') . '.' . $defaultIndex;
                            }
                            @endphp
                        <a href="{{ route($route) }}">
                            <i class="{{ $element['custom_icon'] ?: $element['icon']  }}"></i>
                            {!! $element['custom_label'] ?: $element['label']  !!}
                        </a>
                        @else
                            <span>
                                <i class="{{ $element['custom_icon'] ?: $element['icon'] }}"></i>
                                {!! $element['custom_label'] ?: $element['label'] !!}
                            </span>
                        @endif

                        @if (empty($element['children']))
                            @continue
                        @endif
                        <ul class="sidebar-submenu">
                        @foreach($element['children'] as $childName => $child)
                            <li class="{{ (!isset($child['route']) || $child['route'] !== false ? $sidebar->active($childName) : null) }} subsection section-{{ $childName }}">
                                @php
                                    $route = $child['route'];
                                    if (isset($child['tree'])) {
                                        $route = \Illuminate\Support\Str::beforeLast($route, '.') . '.' . $defaultIndex;
                                    }
                                @endphp
                                <a href="{{ route($route) }}">
                                    <i class="{{ $child['custom_icon'] ?: $child['icon'] }}"></i>
                                    {!! $child['custom_label'] ?: $child['label'] !!}
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

            @include('partials.ads.sidebar')
        </section>
    </aside>
    @if (auth()->check() && $currentCampaign->userIsMember())
        <section class="sidebar-creator" data-toggle="tooltip" title="{{ __('entities.creator.tooltip') }}">
            <a href="#" data-url="{{ route('entity-creator.selection') }}" data-toggle="ajax-modal" data-target="#entity-modal">
                <i class="fa fa-plus"></i> <span>{{ __('sidebar.new-entity') }}</span>
            </a>
        </section>
    @endif
@elseif (auth()->check() && auth()->user()->hasCampaigns())
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                @foreach (\App\Facades\UserCache::campaigns() as $userCampaign)
                    <li class="section-campaign section-campaign-{{ $userCampaign->id }}">
                        <a href="{{ url(App::getLocale() . '/' . $userCampaign->getMiddlewareLink()) }}">
                            <i class="fa fa-globe"></i>
                            {!! $userCampaign->name !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif
