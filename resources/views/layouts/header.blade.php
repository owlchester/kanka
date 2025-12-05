<header id="header" class="fixed top-0 h-12 w-full bg-navbar bg-base-100 z-900">
    <nav class="flex gap-2 justify-center items-center h-full px-3">
        <noscript>
                <span class="bg-error text-error-content p-1 rounded text-sm">
                    Kanka requires Javascript to work properly. Please enable it.
                </span>
        </noscript>
        <div class="flex-none flex md:w-sidebar justify-items items-center toggle-and-search gap-2">
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

        @if (auth()->check() && !empty($campaign) && auth()->user()->can('member', $campaign) && (!isset($qq) || $qq))
        <div class="flex-none">
            <a href="#" data-url="{{ route('entity-creator.selection', $campaign) }}" data-toggle="dialog"  class="quick-creator-button btn2 btn-primary btn-sm"
            tabindex="0">
                <x-icon class="flex-none fa-regular fa-plus" />
                <span class="grow hidden sm:inline-block">
                    {{ __('crud.create') }}
                </span>
                <span class="flex-none keyboard-shortcut" id="qq-kb-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>N</code>']) !!}" data-html="true" data-placement="bottom" >N</span>
            </a>
        </div>
        @endif

        <div class="flex-1 navbar-actions">

            <div class="flex justify-end items-center gap-2">
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
                    @if (config('app.debug'))
                        @php
                            $themeUrl = \Illuminate\Support\Str::before(request()->fullUrl(), '_theme=');
                            $themeUrl .= \Illuminate\Support\Str::contains($themeUrl, '?') ? '&' : '?';
                            $premiumUrl = \Illuminate\Support\Str::before(request()->fullUrl(), '_boosted=');
                            $premiumUrl .= \Illuminate\Support\Str::contains($premiumUrl, '?') ? '&' : '?';
                        @endphp
                        <div class="dropdown">
                            <button type="button" class="text-neutral-content hover:text-accent text-2xl" data-dropdown aria-expanded="false">
                                <x-icon class="fa-regular fa-gem" />
                            </button>
                            <div class="dropdown-menu hidden" role="menu">
                                @if (request()->has('_boosted'))
                                <x-dropdowns.item
                                    link="{!! $premiumUrl !!}">
                                    Reset
                                </x-dropdowns.item>
                                @else
                                <x-dropdowns.item
                                    link="{!! $premiumUrl . '_boosted=0' !!}">
                                    Disable premium
                                </x-dropdowns.item>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="text-neutral-content hover:text-accent text-2xl" data-dropdown aria-expanded="false">
                                <x-icon class="fa-regular fa-palette" />
                            </button>
                            <div class="dropdown-menu hidden" role="menu">
                                @if (request()->has('_theme'))
                                <x-dropdowns.item
                                    link="{!! $themeUrl . '' !!}">
                                    Reset
                                </x-dropdowns.item>
                                @endif
                                <x-dropdowns.item
                                    link="{!! $themeUrl . '_theme=base' !!}">
                                    Light
                                </x-dropdowns.item>
                                <x-dropdowns.item
                                    link="{!! $themeUrl . '_theme=dark' !!}">
                                    Dark
                                </x-dropdowns.item>
                                <x-dropdowns.item
                                    link="{!! $themeUrl . '_theme=midnight' !!}">
                                    Midnight
                                </x-dropdowns.item>
                            </div>
                        </div>
                    @endif
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
