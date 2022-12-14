<?php
$currentCampaign = CampaignLocalization::getCampaign();
?>
<header class="main-header @if(isset($startUI) && $startUI) main-header-start @endif">
    <nav class="navbar navbar-static-top flex">
        @if ((auth()->check() && auth()->user()->hasCampaigns()) || !auth()->check())
            <button class="sidebar-toggle" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) !!}" data-placement="right" data-html="true" tabindex="3">
                <span class="sr-only">{{ __('header.toggle_navigation') }}</span>
            </button>
        @endif

        @if (!empty($currentCampaign))
            {!! Form::open(['route' => 'search', 'class' => 'visible-md visible-lg navbar-form navbar-left live-search-form', 'method'=>'GET']) !!}
            <div class="form-group has-feedback flex-grow">
                <div class="flex">
                    <input type="search" name="q" id="live-search" class="typeahead form-control" autocomplete="off"
                           placeholder="{{ __('sidebar.search') }}" data-url="{{ route('search.live') }}"
                           data-empty="{{ __('search.no_results') }}"
                           tabindex="2">
                    <span class="keyboard-shortcut form-control-feedback hidden-xs hidden-sm">K</span>

                    <a href="#" role="button" class="live-search-close visible-xs visible-sm self-end" aria-label="Close search">
                        <i class="fa-solid fa-close" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            {!! Form::close() !!}
        @endif

        <div class="flex-1 navbar-actions">
            <div class="flex justify-end px-3">
                @if (!empty($currentCampaign))
                    <span href="#" role="button" class="visible-xs visible-sm mobile-search text-lg p-3" aria-label="{{ __('crud.search') }}">
                        <span class="fa-solid fa-search" aria-hidden="true"></span>
                    </span>
                @endif

                @guest
                        <a href="{{ route('login') }}" class="hidden-xs">
                            {{ __('front.menu.login') }}
                        </a>
                    @if(config('auth.register_enabled'))
                        <a href="{{ route('register') }}" class="hidden-xs">
                            {{ __('front.menu.register') }}
                        </a>
                    @endif
                @endguest


                @auth()
                    <div id="nav-switcher">
                        <nav-switcher
                            user_id="{{ auth()->user()->id }}"
                            api="{{ route('layout.navigation') }}"
                            fetch="{{ route('notifications.refresh') }}"
                            initials="{{ auth()->user()->initials() }}"
                            campaign_id="{{ !empty($currentCampaign) ? $currentCampaign->id : null }}"
                            :has_alerts="{{ auth()->user()->hasUnread() ? 'true' : 'false'}}"
                        ></nav-switcher>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>
