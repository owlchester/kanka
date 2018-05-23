<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        {{ config('app.name') }}
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        @if (Session::has('campaign_id'))
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('header.toggle_navigation') }}</span>
        </a>
        @endif
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::check() and !empty(Auth::user()->campaign))
                    <?php $currentCampaign = Auth::user()->campaign; ?>
                    <?php $notifications = Auth::user()->unreadNotifications; ?>
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-bell-o"></i>
                                @if (count($notifications) > 0) <span class="label label-warning">{{ count($notifications) }}</span> @endif
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">{{ trans('header.notifications.header', ['count' => Auth::user()->unreadNotifications()->count()]) }}</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        @foreach (Auth::user()->notifications()->take(5)->get() as $notification)
                                            @if (!empty($notification->data['icon']))
                                            <li>
                                                <a href="{{ route('notifications') }}">
                                                    <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i> {{ trans('notifications.' . $notification->data['key'], $notification->data['params']) }}
                                                </a>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="footer"><a href="{{ route('notifications') }}">{{ trans('header.notifications.read_all') }}</a></li>
                            </ul>
                        </li>
                    @if(count(Auth::user()->campaigns) > 1)
                    <li class="dropdown messages-menu campaign-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            @if ($currentCampaign->image)
                                <img src="{{ Storage::url($currentCampaign->image) }}" alt="{{ $currentCampaign->name }}" class="campaign-image" />
                            @else
                                <i class="fa fa-globe"></i>
                            @endif {{ $currentCampaign->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    @foreach (Auth::user()->campaigns as $campaign)
                                        @if ($campaign->id != Auth::user()->campaign->id)
                                            <li>
                                                <a href="{{ route('campaigns.index', ['campaign_id' => $campaign->id]) }}">
                                                    @if ($campaign->image)
                                                        <img src="{{ Storage::url($campaign->image) }}" alt="{{ $campaign->name }}" class="campaign-image" />
                                                    @else
                                                        <i class="fa fa-globe"></i>
                                                    @endif
                                                    {{ $campaign->name }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="messages-menu campaign-menu">
                        <a href="{{ route('home') }}">
                        @if ($currentCampaign->image)
                            <img src="/storage/{{ $currentCampaign->image }}" alt="{{ $currentCampaign->name }}" class="campaign-image" />
                        @else
                            <i class="fa fa-globe"></i>
                        @endif {{ $currentCampaign->name }}
                        </a>
                    </li>
                    @endif
                @endauth
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Auth::user()->getAvatarUrl() }}" class="user-image" alt="{{ trans('header.avatar') }}"/>

                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ Auth::user()->getAvatarUrl() }}" class="img-circle" alt="{{ trans('header.avatar') }}" />
                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ trans('header.member_since', ['date' => Auth::user()->elapsed('created_at')]) }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            @if (session()->has('campaign_id'))
                            <div class="pull-left">
                                <a href="{{ route('profile') }}" class="btn btn-default btn-flat"> {{ trans('header.profile') }}</a>
                            </div>
                            @endif
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ trans('header.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>