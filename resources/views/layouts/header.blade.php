<header id="header" class="fixed top-0 h-12 w-full bg-navbar bg-base-100 z-[900]">
    <nav class="flex gap-2 justify-center items-center h-full">
        <div class="ml-1 flex-none flex md:w-sidebar justify-items items-center toggle-and-search">
        @if (isset($toggle) && $toggle)
            <nav-toggler
                text="{{ __('header.toggle_navigation') }}"
                title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
            ></nav-toggler>
        @endif

        @if (!empty($campaign))
            <nav-search
                api_lookup="{{ route('search.live', $campaign) }}"
                api_recent="{{ route('search.recent', $campaign) }}"
                placeholder="{{ __('search.placeholder') }}"
                keyboard_tooltip="{!! __('crud.keyboard-shortcut', ['code' => '<code>K</code>']) !!}"
            ></nav-search>
        @endif
        </div>

        @if (auth()->check() && !empty($campaign) && $campaign->userIsMember() && (!isset($qq) || $qq))
        <div class="flex-none">
            <a href="#" data-url="{{ route('entity-creator.selection', $campaign) }}" data-toggle="dialog" data-target="primary-dialog" class="quick-creator-button btn2 btn-primary btn-sm"
            tabindex="4">
                <x-icon class="flex-none fa-solid fa-plus ml-1" />
                <span class="grow hidden sm:inline-block">
                    {{ __('crud.create') }}
                </span>
                <span class="flex-none keyboard-shortcut" id="qq-kb-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>N</code>']) !!}" data-html="true" data-placement="bottom" >N</span>
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
                        campaign_id="{{ !empty($campaign) ? $campaign->id : null }}"
                        :has_alerts="{{ auth()->user()->hasUnread() ? 'true' : 'false'}}"
                    ></nav-switcher>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endauth
            </div>
        </div>
    </nav>
</header>
