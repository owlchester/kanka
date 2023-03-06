<?php
$currentCampaign = CampaignLocalization::getCampaign();
?>
<header id="header" class="">
    <nav class="flex gap-2 justify-center items-center fixed top-0 w-full bg-navbar h-12">
        <div class="flex-0 flex w-sidebar justify-items items-center">
        @if ((auth()->check() && auth()->user()->hasCampaigns()) || !auth()->check())
            <nav-toggler
                text="{{ __('header.toggle_navigation') }}"
                title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
            ></nav-toggler>
        @endif

        @if (!empty($currentCampaign))
            <nav-search
                api_lookup="{{ route('search.live') }}"
                api_recent="{{ route('search.recent') }}"
                placeholder="{{ __('SEARCH') }}"
            ></nav-search>
        @endif
        </div>

        @if (auth()->check() && $currentCampaign->userIsMember() && (!isset($qq) || $qq))
        <div class="flex-0">
            <span id="qq-sidebar-btn" class="absolute right-auto" data-content="{{ __('dashboards/widgets/welcome.focus.text') }}" data-placement="bottom"></span>
            <a href="#" data-url="{{ route('entity-creator.selection') }}" data-toggle="ajax-modal" data-target="#entity-modal" class="quick-creator-button flex justify-center text-center gap-2 rounded h-9 min-w-9 px-2 text-uppercase items-center"
            tabindex="4">
                <i class="flex-none fa-solid fa-plus ml-1" aria-hidden="true" ></i>
                <span class="flex-grow hidden-xs">
                    {{ __('crud.create') }}
                </span>
                <span class="flex-none keyboard-shortcut" id="qq-kb-shortcut" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>N</code>']) !!}" data-html="true" data-placement="bottom" >N</span>
            </a>
        </div>
        @endif

        <div class="flex-1 navbar-actions">

            <div class="flex justify-end mr-3">
                    @guest
                        <a href="{{ route('login') }}" class="hidden-xs btn mt-1">
                            {{ __('front.menu.login') }}
                        </a>
                    @if(config('auth.register_enabled'))
                        <a href="{{ route('register') }}" class="hidden-xs btn btn-primary mt-1">
                            {{ __('front.menu.register') }}
                        </a>
                    @endif
                @endguest

                @auth()
                    <nav-switcher
                        user_id="{{ auth()->user()->id }}"
                        api="{{ route('layout.navigation') }}"
                        fetch="{{ route('notifications.refresh') }}"
                        initials="{{ auth()->user()->initials() }}"
                        avatar="{{ auth()->user()->getAvatarUrl(36) }}"
                        campaign_id="{{ !empty($currentCampaign) ? $currentCampaign->id : null }}"
                        :has_alerts="{{ auth()->user()->hasUnread() ? 'true' : 'false'}}"
                        :pro="{{ config('fontawesome.kit') !== false ? 'true' : 'false' }}"
                    ></nav-switcher>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endauth
            </div>
        </div>
    </nav>
</header>
