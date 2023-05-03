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
                <a href="{{ route('settings.profile') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-user" aria-hidden="true"></i>
                    <span>{{ __('settings.menu.profile') }}</span>
                </a>
            </li>
            <li class="px-2 {{ $sidebar->settings('account') }}">
                <a href="{{ route('settings.account') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-cog" aria-hidden="true"></i>
                    <span>{{ __('settings.menu.account') }}</span>
                </a>
            </li>
            <li class="px-2 {{ $sidebar->settings('appearance') }}">
                <a href="{{ route('settings.appearance') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-brush" aria-hidden="true"></i>
                    <span>{{ __('settings.menu.appearance') }}</span>
                </a>
            </li>
            <li class="px-2 {{ $sidebar->settings('notification') }}">
                <a href="{{ route('settings.notifications') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-bell" aria-hidden="true"></i>
                    <span>{{ __('settings.menu.notifications') }}</span>
                </a>
            </li>

            <li class="px-2 ">
                <div class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-bolt" aria-hidden="true"></i>
                    <span>{{ __('settings.menu.subscription') }}</span>
                </div>
                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                    @if (config('services.stripe.enabled'))
                        <li class="p-0 m-0 {{ $sidebar->settings('subscription') }} subsection">
                            <a href="{{ route('settings.subscription') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                <i class="w-6 flex-shrink-0 text-base fa-solid fa-heart" aria-hidden="true"></i>
                                {{ __('billing/menu.overview') }}
                            </a>
                        </li>
                        @if (auth()->user()->hasBoosterNomenclature())
                            <li class="{{ $sidebar->settings('boosters') }} subsection">
                                <a href="{{ route('settings.boost') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-rocket" aria-hidden="true"></i>
                                    {{ __('settings.menu.boosters') }}
                                </a>
                            </li>
                        @else
                            <li class="{{ $sidebar->settings('premium') }} subsection">
                                <a href="{{ route('settings.premium') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                    <i class="w-6 flex-shrink-0 text-base fa-solid fa-rocket" aria-hidden="true"></i>
                                    {{ __('settings.menu.premium') }}
                                </a>
                            </li>
                        @endif
                    @endif

                    @if (config('services.stripe.enabled'))
                        <li class="{{ $sidebar->settings('payment-method', 4) }} subsection">
                            <a href="{{ route('billing.payment-method') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                <i class="w-6 flex-shrink-0 text-base fa-solid fa-credit-card" aria-hidden="true"></i>
                                {{ __('billing/menu.payment-method') }}
                            </a>
                        </li>
                        <li class="{{ $sidebar->settings('history', 4) }} subsection">
                            <a href="{{ route('billing.history') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                                <i class="w-6 flex-shrink-0 text-base fa-solid fa-receipt" aria-hidden="true"></i>
                                {{ __('billing/menu.history') }}
                            </a>
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
                        <a href="{{ route('settings.patreon') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                            <i class="w-6 flex-shrink-0 text-base fa-brands fa-patreon" aria-hidden="true"></i>
                            {{ __('settings.menu.patreon') }}
                        </a>
                    </li>@endif

                    <li class="p-0 m-0 {{ $sidebar->settings('apps') }} subsection">
                        <a href="{{ route('settings.apps') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                            <i class="w-6 flex-shrink-0 text-base fa-brands fa-discord" aria-hidden="true"></i>
                            {{ __('settings.menu.apps') }}
                        </a>
                    </li>
                    <li class="p-0 m-0 {{ $sidebar->settings('api') }} subsection">
                        <a href="{{ route('settings.api') }}" class="flex items-center gap-2 my-0.5 px-2 py-1.5 rounded">
                            <i class="w-6 flex-shrink-0 text-base fa-solid fa-code" aria-hidden="true"></i>
                            {{ __('settings.menu.api') }}
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
</aside>
