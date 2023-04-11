<?php /** @var \App\Services\SidebarService $sidebar */?>
@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar main-sidebar-placeholder">
    <section class="sidebar-campaign">
        <div class="campaign-block">
            <div class="campaign-head">
                <div class="campaign-name">
                    {{ auth()->user()->name }}
                </div>
            </div>
        </div>
    </section>
    <section class="sidebar" style="height: auto">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ $sidebar->settings('profile') }}">
                <a href="{{ route('settings.profile') }}">
                    <i class="fa-solid fa-user" aria-hidden="true"></i>
                    {{ __('settings.menu.profile') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('account') }}">
                <a href="{{ route('settings.account') }}">
                    <i class="fa-solid fa-cog" aria-hidden="true"></i>
                    {{ __('settings.menu.account') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('appearance') }}">
                <a href="{{ route('settings.appearance') }}">
                    <i class="fa-solid fa-brush" aria-hidden="true"></i>
                    {{ __('settings.menu.appearance') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('notification') }}">
                <a href="{{ route('settings.notifications') }}">
                    <i class="fa-solid fa-bell" aria-hidden="true"></i>
                    {{ __('settings.menu.notifications') }}
                </a>
            </li>

            <li class=" ">
                <span>
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                    {{ __('settings.menu.subscription') }}
                </span>
                <ul class="sidebar-submenu">
                    @if (config('services.stripe.enabled'))
                        <li class="{{ $sidebar->settings('subscription') }} subsection">
                            <a href="{{ route('settings.subscription') }}">
                                <i class="fa-solid fa-heart" aria-hidden="true"></i>
                                {{ __('billing/menu.overview') }}
                            </a>
                        </li>
                    @endif
                    <li class="{{ $sidebar->settings('boosters') }} subsection">
                        <a href="{{ route('settings.boost') }}">
                            <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                            {{ __('settings.menu.boosters') }}
                        </a>
                    </li>

                    @if (config('services.stripe.enabled'))
                        <li class="{{ $sidebar->settings('payment-method', 4) }} subsection">
                            <a href="{{ route('billing.payment-method') }}">
                                <i class="fa-solid fa-credit-card" aria-hidden="true"></i>
                                {{ __('billing/menu.payment-method') }}
                            </a>
                        </li>
                        <li class="{{ $sidebar->settings('history', 4) }} subsection">
                            <a href="{{ route('billing.history') }}">
                                <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                                {{ __('billing/menu.history') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </li>


            <li class="section-section">
                <span>
                    <i class="fa-solid fa-cubes"></i>
                    {{ __('settings.menu.other') }}
                </span>

                <ul class="sidebar-submenu">
                    @if (auth()->user()->isLegacyPatron())<li class="{{ $sidebar->settings('patreon') }} subsection">
                        <a href="{{ route('settings.patreon') }}">
                            <i class="fa-brands fa-patreon" aria-hidden="true"></i>
                            {{ __('settings.menu.patreon') }}
                        </a>
                    </li>@endif

                    <li class="{{ $sidebar->settings('apps') }} subsection">
                        <a href="{{ route('settings.apps') }}">
                            <i class="fa-brands fa-discord" aria-hidden="true"></i>
                            {{ __('settings.menu.apps') }}
                        </a>
                    </li>
                    <li class="{{ $sidebar->settings('api') }} subsection">
                        <a href="{{ route('settings.api') }}">
                            <i class="fa-solid fa-code" aria-hidden="true"></i>
                            {{ __('settings.menu.api') }}
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
</aside>
