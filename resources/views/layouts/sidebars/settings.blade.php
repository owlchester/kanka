<?php /** @var \App\Services\SidebarService $sidebar */?>
@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar">
    <section class="sidebar" style="height: auto">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-globe"></i>
                    <span>{{ __('entities.campaigns') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display:none">

                    @foreach (Auth::user()->campaigns as $campaign)
                    <li class="campaign-name">
                        <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}"><i class="fa fa-globe"></i> <span>{!! $campaign->name !!}</span></a>
                    </li>
                    @endforeach
                </ul>
            </li>

            <li class="{{ $sidebar->settings('profile') }}">
                <a href="{{ route('settings.profile') }}">
                    <i class="fa fa-user"></i> {{ __('settings.menu.profile') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('account') }}">
                <a href="{{ route('settings.account') }}">
                    <i class="fa fa-key"></i> {{ __('settings.menu.account') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('layout') }}">
                <a href="{{ route('settings.layout') }}">
                    <i class="fas fa-th-large"></i> {{ __('settings.menu.layout') }}
                </a>
            </li>

            <li class="header">{{ __('settings.menu.subscription') }}</li>
            <li class="{{ $sidebar->settings('boost') }}">
                <a href="{{ route('settings.boost') }}">
                    <i class="fa fa-rocket"></i> {{ __('settings.menu.boost') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('billing-information') }}">
                <a href="{{ route('settings.billing') }}">
                    <i class="far fa-circle"></i> {{ __('settings.menu.billing') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('subscription') }}">
                <a href="{{ route('settings.subscription') }}">
                    <i class="far fa-circle"></i> {{ __('settings.menu.subscription_status') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('invoices') }}">
                <a href="{{ route('settings.invoices') }}">
                    <i class="far fa-circle"></i> {{ __('settings.menu.invoices') }}
                </a>
            </li>

            <li class="header">{{ __('settings.menu.other') }}</li>
            @if (Auth::user()->hasPatreonSync())<li class="{{ $sidebar->settings('patreon') }}">
                <a href="{{ route('settings.patreon') }}">
                    <i class="fab fa-patreon"></i> {{ __('settings.menu.patreon') }}
                </a>
            </li>@endif

            <li class="{{ $sidebar->settings('apps') }}">
                <a href="{{ route('settings.apps') }}">
                    <i class="fab fa-discord"></i> {{ __('settings.menu.apps') }}
                </a>
            </li>
            <li class="{{ $sidebar->settings('api') }}">
                <a href="{{ route('settings.api') }}">
                    <i class="fas fa-code"></i> {{ __('settings.menu.api') }}
                </a>
            </li>
        </ul>
    </section>
</aside>
