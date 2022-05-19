<?php /** @var \App\Services\SidebarService $sidebar */?>
@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar main-sidebar-placeholder">
    <section class="sidebar-campaign">
        <div class="campaign-block">
            <div class="campaign-head">
                <div class="campaign-name" data-toggle="collapse" data-target="#campaign-switcher">
                    <i class="fa-solid fa-caret-down pull-right"></i>
                    {{ auth()->user()->name }}
                </div>
            </div>
        </div>
    </section>
    @include('layouts.sidebars.campaign-switcher', ['fromSettings' => true])
    <section class="sidebar" style="height: auto">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ $sidebar->settings('profile') }}">
                <a href="{{ route('settings.profile') }}">
                    <i class="fa-solid fa-user"></i>
                    {{ __('settings.menu.profile') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('account') }}">
                <a href="{{ route('settings.account') }}">
                    <i class="fa-solid fa-cog"></i>
                    {{ __('settings.menu.account') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('appearance') }}">
                <a href="{{ route('settings.appearance') }}">
                    <i class="fa-solid fa-brush"></i>
                    {{ __('settings.menu.appearance') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('notification') }}">
                <a href="{{ route('settings.notifications') }}">
                    <i class="fa-solid fa-bell"></i>
                    {{ __('settings.menu.notifications') }}
                </a>
            </li>

            <li class=" ">
                <span>
                    <i class="fa-solid fa-bolt"></i>
                    {{ __('settings.menu.subscription') }}
                </span>
                <ul class="sidebar-submenu">
                    <li class="{{ $sidebar->settings('boost') }} subsection">
                        <a href="{{ route('settings.boost') }}">
                            <i class="fa-solid fa-rocket"></i>
                            {{ __('settings.menu.boosters') }}
                        </a>
                    </li>

                    @if (config('services.stripe.enabled'))
                        <li class="{{ $sidebar->settings('billing-information') }} subsection">
                            <a href="{{ route('settings.billing') }}">
                                <i class="fa-solid fa-credit-card"></i>
                                {{ __('settings.menu.billing') }}
                            </a>
                        </li>
                        <li class="{{ $sidebar->settings('subscription') }} subsection">
                            <a href="{{ route('settings.subscription') }}">
                                <i class="fa-solid fa-heart"></i>
                                {{ __('settings.menu.subscription_status') }}
                            </a>
                        </li>
                        <li class="{{ $sidebar->settings('invoices') }} subsection">
                            <a href="{{ route('settings.invoices') }}">
                                <i class="fa-solid fa-receipt"></i>
                                {{ __('settings.menu.invoices') }}
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
                    @if (auth()->user()->hasPatreonSync())<li class="{{ $sidebar->settings('patreon') }} subsection">
                        <a href="{{ route('settings.patreon') }}">
                            <i class="fa-brands fa-patreon"></i>
                            {{ __('settings.menu.patreon') }}
                        </a>
                    </li>@endif

                    <li class="{{ $sidebar->settings('apps') }} subsection">
                        <a href="{{ route('settings.apps') }}">
                            <i class="fa-brands fa-discord"></i>
                            {{ __('settings.menu.apps') }}
                        </a>
                    </li>
                    <li class="{{ $sidebar->settings('api') }} subsection">
                        <a href="{{ route('settings.api') }}">
                            <i class="fa-solid fa-code"></i>
                            {{ __('settings.menu.api') }}
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
</aside>
