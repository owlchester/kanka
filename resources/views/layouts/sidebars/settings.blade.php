<?php /** @var \App\Services\SidebarService $sidebar */?>
@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar main-sidebar-placeholder">
    <section class="sidebar-campaign">
        <div class="campaign-block">
            <div class="campaign-head">
                <div class="campaign-name" data-toggle="collapse" data-target="#campaign-switcher">
                    <i class="fa fa-caret-down pull-right"></i>
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
                    <i class="fa fa-user"></i>
                    {{ __('settings.menu.profile') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('account') }}">
                <a href="{{ route('settings.account') }}">
                    <i class="fa fa-key"></i>
                    {{ __('settings.menu.account') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('layout') }}">
                <a href="{{ route('settings.layout') }}">
                    <i class="fas fa-th-large"></i>
                    {{ __('settings.menu.layout') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('marketplace') }}">
                <a href="{{ route('settings.marketplace') }}">
                    <i class="fas fa-palette"></i>
                    {{ __('settings.menu.marketplace') }}
                </a>
            </li>


            <li class=" ">
                <span>
                    <i class="fa fa-bolt"></i>
                    {{ __('settings.menu.subscription') }}
                </span>
                <ul class="sidebar-submenu">
                    <li class="{{ $sidebar->settings('boost') }} subsection">
                        <a href="{{ route('settings.boost') }}">
                            <i class="fa fa-rocket"></i>
                            {{ __('settings.menu.boost') }}
                        </a>
                    </li>

                    @if (config('services.stripe.enabled'))
                        <li class="{{ $sidebar->settings('billing-information') }} subsection">
                            <a href="{{ route('settings.billing') }}">
                                <i class="fa fa-credit-card"></i>
                                {{ __('settings.menu.billing') }}
                            </a>
                        </li>
                        <li class="{{ $sidebar->settings('subscription') }} subsection">
                            <a href="{{ route('settings.subscription') }}">
                                <i class="fa fa-heart"></i>
                                {{ __('settings.menu.subscription_status') }}
                            </a>
                        </li>
                        <li class="{{ $sidebar->settings('invoices') }} subsection">
                            <a href="{{ route('settings.invoices') }}">
                                <i class="fa fa-receipt"></i>
                                {{ __('settings.menu.invoices') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </li>


            <li class="section-section">
                <span>
                    <i class="fa fa-cubes"></i>
                    {{ __('settings.menu.other') }}
                </span>

                <ul class="sidebar-submenu">
                    @if (auth()->user()->hasPatreonSync())<li class="{{ $sidebar->settings('patreon') }} subsection">
                        <a href="{{ route('settings.patreon') }}">
                            <i class="fab fa-patreon"></i>
                            {{ __('settings.menu.patreon') }}
                        </a>
                    </li>@endif

                    <li class="{{ $sidebar->settings('apps') }} subsection">
                        <a href="{{ route('settings.apps') }}">
                            <i class="fab fa-discord"></i>
                            {{ __('settings.menu.apps') }}
                        </a>
                    </li>
                    <li class="{{ $sidebar->settings('api') }} subsection">
                        <a href="{{ route('settings.api') }}">
                            <i class="fas fa-code"></i>
                            {{ __('settings.menu.api') }}
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
</aside>
