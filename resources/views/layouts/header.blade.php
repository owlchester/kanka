@php
    $impersonation = auth()->check() && \App\Facades\Identity::isImpersonating() ? [
        'label' => __('campaigns.members.impersonating.acting_as', ['name' => auth()->user()->name]),
        'shortLabel' => __('campaigns.members.impersonating.acting_as_short'),
        'returnLabel' => __('campaigns.members.actions.switch-back'),
        'returnUrl' => route('identity.back', $campaign ?? \App\Facades\Identity::getCampaignId()),
        'roles' => \App\Facades\Identity::campaignRoleNames(auth()->user()),
        'rolesLabel' => __('campaigns.members.fields.roles'),
        'noRolesLabel' => __('campaigns.members.impersonating.no_roles'),
    ] : null;
@endphp
<header id="header" class="fixed top-0 h-13 md:h-12 w-full bg-navbar bg-base-100 z-900">
    <nav class="flex gap-2 justify-center items-center h-full px-3">
        <noscript>
                <span class="bg-error text-error-content p-1 rounded text-sm">
                    Kanka requires Javascript to work properly. Please enable it.
                </span>
        </noscript>
        <div class="flex-none flex justify-items items-center toggle-and-search gap-2 @if (!empty($campaign)) max-md:hidden @endif">
        @if (isset($toggle) && $toggle)
            <nav-toggler
                text="{{ __('header.toggle_navigation') }}"
                title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
            ></nav-toggler>
        @endif

        @if (!empty($campaign))
            <nav-search
                placeholder="{{ __('crud.search') }}"
                keyboard_tooltip="{{ __('crud.keyboard-shortcut', ['code' => '<code>K</code>']) }}"
            ></nav-search>
            <command-center
                back_text="{{ __('crud.actions.back') }}"
                search_text="{{ __('crud.search') }}"
                api_command="{{ route('search.command', $campaign) }}"
                api_recent="{{ route('search.recent', $campaign) }}"
                placeholder="{{ __('search.placeholder') }}"
            ></command-center>
        @endif
        </div>
        @includeWhen(auth()->check() && !empty($campaign) && auth()->user()->can('member', $campaign) && (!isset($qq) || $qq), 'layouts.header.qq')

        <div class="flex-1 navbar-actions @if (!empty($campaign)) max-md:flex-none @endif">

            <div class="flex justify-end items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="text-link">
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
                        <div class="dropdown max-md:hidden">
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
                        <div class="dropdown max-md:hidden">
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
                        campaign_name="{{ !empty($campaign) ? $campaign->name : '' }}"
                        campaigns_label="{{ __('entities.campaigns') }}"
                        close_label="{{ __('crud.actions.close') }}"
                        :has_alerts="{{ auth()->user()->hasUnread() ? 'true' : 'false'}}"
                        @if ($impersonation)
                            :impersonation="{{ \Illuminate\Support\Js::encode($impersonation) }}"
                        @endif
                    ></nav-switcher>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    @if (!empty($campaign))
        @php
            $mobileAccountTexts = array_merge(__('mobile.account'), [
                'title' => __('settings.menu.account'),
                'unread' => __('notifications.unread'),
                'home' => __('sidebar.dashboard'),
                'worlds' => __('entities.campaigns'),
                'your_worlds' => __('sidebar.campaign_switcher.created_campaigns'),
                'followed_worlds' => __('sidebar.campaign_switcher.followed_campaigns'),
                'new_world' => __('sidebar.campaign_switcher.new_campaign'),
                'discover' => __('sidebar.campaign_switcher.follow_more'),
                'preferences' => __('header.user.settings'),
                'more' => __('More'),
                'register' => __('auth.login.sign-up'),
                'loading' => __('Loading'),
                'error' => __('conversations.messages.request_failed'),
                'retry' => __('events.participants.retry'),
            ]);
        @endphp
        <mobile-navigation
            navigation-label="{{ __('header.toggle_navigation') }}"
            explore-label="{{ __('maps.actions.explore') }}"
            search-label="{{ __('crud.search') }}"
            create-label="{{ __('sidebar.entity-creator') }}"
            :authenticated="{{ auth()->check() ? 'true' : 'false' }}"
            :account-texts='@json($mobileAccountTexts)'
            @if ($impersonation)
                :impersonation="{{ \Illuminate\Support\Js::encode($impersonation) }}"
            @endif
            world-name="{{ $campaign->name }}"
            world-url="{{ route('dashboard', $campaign) }}"
            back-label="{{ __('crud.actions.back') }}"
            close-label="{{ __('crud.actions.close') }}"
            login-label="{{ __('front.menu.login') }}"
            login-url="{{ \Illuminate\Support\Facades\URL::signedRoute('login', ['return_to' => request()->getRequestUri()]) }}"
            @if (config('auth.register_enabled'))
                register-url="{{ \Illuminate\Support\Facades\URL::signedRoute('register', ['return_to' => request()->getRequestUri()]) }}"
            @endif
            @auth
                account-api="{{ route('layout.navigation') }}"
                avatar="{{ auth()->user()->getAvatarUrl(36) }}"
                initials="{{ auth()->user()->initials() }}"
                :has-alerts="{{ auth()->user()->hasUnread() ? 'true' : 'false' }}"
            @else
                :has-alerts="false"
            @endauth
            @if (auth()->check() && auth()->user()->can('member', $campaign) && (!isset($qq) || $qq))
                quick-create-url="{{ route('entity-creator.selection', $campaign) }}"
            @endif
        ></mobile-navigation>
    @endif
</header>
