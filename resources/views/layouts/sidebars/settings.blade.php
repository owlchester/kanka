<?php /** @var \App\Services\SidebarService $sidebar */?>
@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar main-sidebar-placeholder t-0 l-0 absolute">
    <section class="sidebar-campaign h-40 overflow-hidden">
        <div class="campaign-block h-32 px-4 pt-24">
            <div class="campaign-head">
                <div class="campaign-name truncate text-xl">
                    {{ auth()->user()->name }}
                </div>
            </div>
        </div>
    </section>
    <section class="sidebar" style="height: auto">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap m-0 p-0 list-none mb-14">
            <li class="px-2 {{ $sidebar->settings('profile') }}">
                <x-sidebar.element
                    :url="route('settings.profile')"
                    icon="fa-solid fa-user"
                    :text="__('settings.menu.profile')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $sidebar->settings('account') }}">
                <x-sidebar.element
                    :url="route('settings.account')"
                    icon="fa-solid fa-cog"
                    :text="__('settings.menu.account')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $sidebar->settings('appearance') }}">
                <x-sidebar.element
                    :url="route('settings.appearance')"
                    icon="fa-solid fa-brush"
                    :text="__('settings.menu.appearance')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $sidebar->settings('newsletter') }}">
                <x-sidebar.element
                    :url="route('settings.newsletter')"
                    icon="fa-solid fa-bell"
                    :text="__('settings.menu.notifications')"
                ></x-sidebar.element>
            </li>

            <li class="px-2 ">
                <x-sidebar.element
                    icon="fa-solid fa-bolt"
                    :text="__('settings.menu.subscription')"
                ></x-sidebar.element>
                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                    @if (config('services.stripe.enabled'))
                        <li class="p-0 m-0 {{ $sidebar->settings('subscription') }} subsection">
                            <x-sidebar.element
                                :url="route('settings.subscription')"
                                icon="fa-solid fa-heart"
                                :text="__('billing/menu.overview')"
                            ></x-sidebar.element>
                        </li>
                        @if (auth()->user()->hasBoosterNomenclature())
                            <li class="{{ $sidebar->settings('boosters') }} subsection">
                                <x-sidebar.element
                                    :url="route('settings.boost')"
                                    icon="fa-solid fa-rocket"
                                    :text="__('settings.menu.boosters')"
                                ></x-sidebar.element>
                            </li>
                        @else
                            <li class="{{ $sidebar->settings('premium') }} subsection">
                                <x-sidebar.element
                                    :url="route('settings.premium')"
                                    icon="fa-solid fa-gem"
                                    :text="__('settings.menu.premium')"
                                ></x-sidebar.element>
                            </li>
                        @endif
                    @endif

                    @if (config('services.stripe.enabled'))
                        <li class="{{ $sidebar->settings('payment-method', 3) }} subsection">
                            <x-sidebar.element
                                :url="route('billing.payment-method')"
                                icon="fa-solid fa-credit-card"
                                :text="__('billing/menu.payment-method')"
                            ></x-sidebar.element>
                        </li>
                        <li class="{{ $sidebar->settings('history', 3) }} subsection">
                            <x-sidebar.element
                                :url="route('billing.history')"
                                icon="fa-solid fa-receipt"
                                :text="__('billing/menu.history')"
                            ></x-sidebar.element>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="px-2">
                <div class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-cubes"></i>
                    <span>{{ __('settings.menu.other') }}</span>
                </div>

                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                    @if (auth()->user()->isLegacyPatron())<li class="{{ $sidebar->settings('patreon') }} subsection">
                        <x-sidebar.element
                            :url="route('settings.patreon')"
                            icon="fa-brands fa-patreon"
                            :text="__('settings.menu.patreon')"
                        ></x-sidebar.element>
                    </li>@endif

                    <li class="p-0 m-0 {{ $sidebar->settings('apps') }} subsection">
                        <x-sidebar.element
                            :url="route('settings.apps')"
                            icon="fa-brands fa-discord"
                            :text="__('settings.menu.apps')"
                        ></x-sidebar.element>
                    </li>
                    <li class="p-0 m-0 {{ $sidebar->settings('api') }} subsection">
                        <x-sidebar.element
                            :url="route('settings.api')"
                            icon="fa-solid fa-code"
                            :text="__('settings.menu.api')"
                        ></x-sidebar.element>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
</aside>
