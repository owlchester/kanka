<?php
$currentCampaign = CampaignLocalization::getCampaign();

$notifications = [];
$unreadNotifications = 0;
if (Auth::check()) {
    $unreadNotifications = count(Auth::user()->unreadNotifications);
    $notifications = Auth::user()->notifications()->take(5)->get();
}
?>
<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        {{ config('app.name') }}
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        @if ((Auth::check() && Auth::user()->hasCampaigns()) || !Auth::check())
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('header.toggle_navigation') }}</span>
        </a>
        @endif
        @if (!empty($currentCampaign))
            {!! Form::open(['route' => 'search', 'class' => 'visible-md visible-lg navbar-form navbar-left live-search-form', 'method'=>'GET']) !!}
                <input type="text" name="q" id="live-search" class="typeahead form-control" autocomplete="off"
                       placeholder="{{ trans('sidebar.search') }}" data-url="{{ route('search.live') }}"
                       data-empty="{{ trans('search.no_results') }}">

                    <a href="#" class="live-search-close visible-xs visible-sm pull-right" name="search-close">
                        <i class="fa fa-close"></i>
                    </a>
            {!! Form::close() !!}
        @endif

        <!-- Navbar Right Menu -->
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
                @if (Auth::check() && Auth::user()->hasCampaigns())
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" name="list-user-campaigns">
                            <i class="far fa-bell"></i>
                            <span id="header-notification-count" class="label label-warning" style="{{ ($unreadNotifications == 0 ? 'display:none' : '') }}">{{ $unreadNotifications }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">{{ trans('header.notifications.header', ['count' => $unreadNotifications]) }}</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu" id="header-notification-list" data-url="{{ route('notifications.refresh') }}">
                                    @include('notifications.list', ['notifications' => $notifications])
                                </ul>
                            </li>
                            <li class="footer"><a href="{{ route('notifications') }}">{{ trans('header.notifications.read_all') }}</a></li>
                        </ul>
                    </li>
                @endif
                <!-- If there is a current campaign and (the user has at least one other campaign or the user isn't part of the current campaign) -->
                @if(Auth::check() && $currentCampaign)
                    <li class="dropdown messages-menu campaign-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" name="list-current-campaigns">
                            @if ($currentCampaign->image)
                                <img src="{{ $currentCampaign->getImageUrl(true) }}" alt="{{ $currentCampaign->name }}" class="campaign-image" />
                            @else
                                <i class="fa fa-globe"></i>
                            @endif <span class="hidden-xs hidden-sm">{{ $currentCampaign->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    @foreach (Auth::user()->campaigns as $campaign)
                                        @if ($campaign->id != $currentCampaign->id)
                                            <li>
                                                <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}">
                                                    @if ($campaign->image)
                                                        <img src="{{ $campaign->getImageUrl(true) }}" alt="{{ $campaign->name }}" class="campaign-image" />
                                                    @else
                                                        <i class="fa fa-globe"></i>
                                                    @endif
                                                    {{ $campaign->name }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                    @can('create', \App\Models\Campaign::class)
                                    <li>
                                        <a href="{{ !Auth::user()->hasCampaigns() ? route('start') : route('campaigns.create') }}">
                                            <i class="fa fa-plus"></i> {{ trans('campaigns.index.actions.new.title') }}
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @elseif (!empty($currentCampaign))
                    <li class="messages-menu campaign-menu">
                        <a href="{{ route('dashboard') }}">
                            @if ($currentCampaign->image)
                                <img src="{{ $currentCampaign->getImageUrl(true) }}" alt="{{ $currentCampaign->name }}" class="campaign-image" />
                            @else
                                <i class="fa fa-globe"></i>
                            @endif <span class="hidden-xs hidden-sm">{{ $currentCampaign->name }}</span>
                        </a>
                    </li>
                @endif
                @if(!Auth::check())
                    <li class="messages-menu">
                        <a href="{{ route('login') }}">{{ trans('front.menu.login') }}</a>
                    </li>
                    <li class="messages-menu hidden-xs">
                        <a href="{{ route('register') }}">{{ trans('front.menu.register') }}</a>
                    </li>
                @endif
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" name="list-languages">
                        <i class="fa fa-caret-down"></i> {{ LaravelLocalization::getCurrentLocaleNative() }}
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('languages.header') }}</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $langData)
                                    <?php $url = LaravelLocalization::getLocalizedURL($localeCode, null, [], true); ?>
                                    <li>
                                    @if (App::getLocale() == $localeCode)
                                        <a href="#"><strong>{{ $langData['native'] }}</strong></a>
                                    @else
                                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                                            {{ $langData['native'] }}
                                        </a>
                                    @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>

                <? /* added the test because sometimes the session exists but the user isn't authenticated */ ?>
                @if (Auth::check())
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" name="list-user-profile-actions">
                        <img src="{{ Auth::user()->getAvatarUrl(true) }}" class="user-image" alt="{{ trans('header.avatar') }}"/>

                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <a href="{{ route('settings.profile') }}">
                                <img src="{{ Auth::user()->getAvatarUrl(true) }}" class="img-circle" alt="{{ trans('header.avatar') }}" />
                            </a>
                            <p>
                                {{ Auth::user()->name }}
                                <small title="{{ auth()->user()->created_at }}">{{ trans('header.member_since', ['date' => Auth::user()->created_at->diffForHumans()]) }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            @if (Auth::user()->hasCampaigns())
                            <div class="pull-left">
                                <a href="{{ route('settings.profile') }}" class="btn btn-default btn-flat"> {{ trans('header.profile') }}</a>
                            </div>
                            @endif
                            <div class="pull-right">
                                @if (\App\Facades\Identity::isImpersonating())

                                    <a href="{{ route('identity.back') }}" class="btn btn-default">
                                        <i class="fa fa-sign-out-alt"></i> {{ trans('campaigns.members.actions.switch-back') }}
                                    </a>
                                @else
                                <a href="{{ route('logout') }}" class="btn btn-default" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ trans('header.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                @endif
                            </div>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>