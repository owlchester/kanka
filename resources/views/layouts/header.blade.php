<?php
$currentCampaign = CampaignLocalization::getCampaign();
?>
<header id="header" class="">
    <nav class="flex gap-2 justify-center items-center fixed top-0 w-full bg-navbar h-12">
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

        <div class="flex-1 navbar-actions">
            <div class="flex justify-end px-3">
                @if (!empty($currentCampaign))
                    <span href="#" role="button" class="visible-xs visible-sm mobile-search text-lg p-3" aria-label="{{ __('crud.search') }}">
                        <span class="fa-solid fa-search" aria-hidden="true"></span>
                    </span>
                @endif

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
