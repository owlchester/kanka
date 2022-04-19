<?php
$currentCampaign = CampaignLocalization::getCampaign();
?>
<header class="main-header @if(isset($startUI) && $startUI) main-header-start @endif">

{{--    @if ((Auth::check() && Auth::user()->hasCampaigns()) || !Auth::check())--}}
{{--        <!-- Sidebar toggle button-->--}}
{{--        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">--}}
{{--            <span class="sr-only">{{ __('header.toggle_navigation') }}</span>--}}
{{--        </a>--}}
{{--    @endif--}}

    <nav class="navbar navbar-static-top">
        @if ((auth()->check() && auth()->user()->hasCampaigns()) || !auth()->check())
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" tabindex="3">
                <span class="sr-only">{{ __('header.toggle_navigation') }}</span>
            </a>
        @endif

        @if (!empty($currentCampaign))
            {!! Form::open(['route' => 'search', 'class' => 'visible-md visible-lg navbar-form navbar-left live-search-form', 'method'=>'GET']) !!}
                <input type="text" name="q" id="live-search" class="typeahead form-control" autocomplete="off"
                       placeholder="{{ __('sidebar.search') }}" data-url="{{ route('search.live') }}"
                       data-empty="{{ __('search.no_results') }}"
                       tabindex="2">

                    <a href="#" class="live-search-close visible-xs visible-sm pull-right" name="search-close">
                        <i class="fa fa-close"></i>
                    </a>
            {!! Form::close() !!}
        @endif

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (!empty($currentCampaign))
                    <li class="visible-xs visible-sm">
                        <a href="#" class="mobile-search">
                            <span class="fa fa-search"></span>
                        </a>
                    </li>
                @endif
                <!-- Only logged in users can have this dropdown, Also only show this if the user has campaigns -->
                @if (auth()->check() && !\App\Facades\Identity::isImpersonating())
                    <li class="dropdown notifications-menu" data-user-id="{{ auth()->user()->id }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="far fa-bell"></i>
                            <span id="header-notification-count" class="label label-warning" style="display:none"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="notification-footer">
                                <a href="{{ route('notifications') }}">
                                    {{ __('header.notifications.read_all') }}
                                </a>

                                <a href="#" class="pull-right" id="header-notification-mark-all-as-read" data-url="{{ route('notifications.refresh', 'read-all') }}">
                                    {{ __('header.notifications.mark_read') }}
                                </a>
                            </li>
                            <li>
                                <ul class="menu" id="header-notification-list" data-url="{{ route('notifications.refresh') }}">
                                    <li class="text-center"><i class="fa fa-spin fa-spinner"></i></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
                @guest
                    <li class="messages-menu">
                        <a href="{{ route('login') }}">{{ __('front.menu.login') }}</a>
                    </li>@if(config('auth.register_enabled'))
                    <li class="messages-menu hidden-xs">
                        <a href="{{ route('register') }}">{{ __('front.menu.register') }}</a>
                    </li>@endif
                @endguest

                @auth()

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="{{ auth()->user()->name }}">
                        <img src="{{ auth()->user()->getAvatarUrl() }}" class="user-image" alt="{{ __('header.avatar') }}"/>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <a href="{{ route('users.profile', auth()->user()) }}">
                                <img src="{{ auth()->user()->getAvatarUrl(100) }}" class="img-circle" alt="{{ __('header.avatar') }}" />
                            </a>
                            <p>
                                <a href="{{ route('users.profile', auth()->user()) }}">{{ auth()->user()->name }}</a>
                                <small title="{{ auth()->user()->created_at }}">{{ __('header.member_since', ['date' => auth()->user()->created_at->diffForHumans()]) }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            @if (auth()->user()->hasCampaigns())
                            <div class="pull-left">
                                <a href="{{ route('settings.profile') }}" class="btn btn-default btn-flat"> {{ __('header.profile') }}</a>
                            </div>
                            @endif
                            <div class="pull-right">
                                @if (\App\Facades\Identity::isImpersonating())

                                    <a href="{{ route('identity.back') }}" class="btn btn-default btn-flat switch-back">
                                        <i class="fa fa-sign-out-alt"></i> {{ __('campaigns.members.actions.switch-back') }}
                                    </a>
                                @else
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('header.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                @endif
                            </div>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
