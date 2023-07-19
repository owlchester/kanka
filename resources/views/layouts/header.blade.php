<?php
$currentCampaign = CampaignLocalization::getCampaign();
?>
<header id="header" class="fixed top-0 h-12 w-full bg-navbar bg-base-100 z-[900]">
    <nav class="flex gap-2 justify-center items-center h-full">
        <div class="ml-1 flex-none flex md:w-sidebar justify-items items-center toggle-and-search">
        @if (isset($toggle) && $toggle)
            <nav-toggler
                text="{{ __('header.toggle_navigation') }}"
                title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
            ></nav-toggler>
        @endif

        @if (!empty($currentCampaign))
            <nav-search
                api_lookup="{{ route('search.live') }}"
                api_recent="{{ route('search.recent') }}"
                placeholder="{{ __('search.placeholder') }}"
                keyboard_tooltip="{!! __('crud.keyboard-shortcut', ['code' => '<code>K</code>']) !!}"
            ></nav-search>
        @endif
        </div>

        @if (auth()->check() && !empty($currentCampaign) && $currentCampaign->userIsMember() && (!isset($qq) || $qq))
        <div class="flex-none">
            <span id="qq-sidebar-btn" class="absolute right-auto" data-content="{{ __('dashboards/widgets/welcome.focus.text') }}" data-placement="bottom"></span>
            <a href="#" data-url="{{ route('entity-creator.selection') }}" data-toggle="ajax-modal" data-target="#entity-modal" class="quick-creator-button btn2 btn-primary btn-sm"
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

            <div class="flex justify-end mr-3 items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="">
                        {{ __('front.menu.login') }}
                    </a>
                    @if(config('auth.register_enabled'))
                        <a href="{{ route('register') }}" class="btn2 btn-primary btn-xs">
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
