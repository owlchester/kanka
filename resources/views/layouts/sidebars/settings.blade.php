<?php /** @var \App\Services\SidebarService $sidebar */?>
@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar main-sidebar-placeholder">
    <section class="sidebar-campaign">
        <div class="campaign-block">
            <div class="campaign-head">
                <div class="campaign-name" data-toggle="collapse" data-target="#campaign-switcher">
                    <i class="fa fa-caret-down pull-right"></i>
                    {{ Auth::user()->name }}
                </div>

            </div>
        </div>
    </section>
    @include('layouts.sidebars.campaign-switcher', ['newCampaign' => false])
    <section class="sidebar" style="height: auto">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ $sidebar->settings('profile') }}">
                <a href="{{ route('settings.profile') }}">
                    <i class="fa fa-user"></i> <span>{{ __('settings.menu.profile') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('account') }}">
                <a href="{{ route('settings.account') }}">
                    <i class="fa fa-key"></i> <span>{{ __('settings.menu.account') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('layout') }}">
                <a href="{{ route('settings.layout') }}">
                    <i class="fas fa-th-large"></i> <span>{{ __('settings.menu.layout') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('marketplace') }}">
                <a href="{{ route('settings.marketplace') }}">
                    <i class="fas fa-shopping-cart"></i> <span>{{ __('settings.menu.marketplace') }}</span>
                </a>
            </li>


            <li class="sidebar-section">
                <div class="sidebar-text">
                    <i class="fa fa-bolt"></i>
                    <span>{{ trans('settings.menu.subscription') }}</span>
                </div>
            </li>

            <li class="{{ $sidebar->settings('boost') }} subsection">
                <a href="{{ route('settings.boost') }}">
                    <i class="fa fa-rocket"></i> <span>{{ __('settings.menu.boost') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('billing-information') }} subsection">
                <a href="{{ route('settings.billing') }}">
                    <i class="fa fa-credit-card"></i> <span>{{ __('settings.menu.billing') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('subscription') }} subsection">
                <a href="{{ route('settings.subscription') }}">
                    <i class="fa fa-heart"></i> <span>{{ __('settings.menu.subscription_status') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('invoices') }} subsection">
                <a href="{{ route('settings.invoices') }}">
                    <i class="fa fa-receipt"></i> <span>{{ __('settings.menu.invoices') }}</span>
                </a>
            </li>


            <li class="sidebar-section">
                <div class="sidebar-text">
                    <i class="fa fa-cubes"></i>
                    <span>{{ trans('settings.menu.other') }}</span>
                </div>
            </li>
            @if (Auth::user()->hasPatreonSync())<li class="{{ $sidebar->settings('patreon') }} subsection">
                <a href="{{ route('settings.patreon') }}">
                    <i class="fab fa-patreon"></i> <span>{{ __('settings.menu.patreon') }}</span>
                </a>
            </li>@endif

            <li class="{{ $sidebar->settings('apps') }} subsection">
                <a href="{{ route('settings.apps') }}">
                    <i class="fab fa-discord"></i> <span>{{ __('settings.menu.apps') }}</span>
                </a>
            </li>
            <li class="{{ $sidebar->settings('api') }} subsection">
                <a href="{{ route('settings.api') }}">
                    <i class="fas fa-code"></i> <span>{{ __('settings.menu.api') }}</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
