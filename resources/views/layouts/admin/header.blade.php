<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        {{ config('app.name') }}
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('header.toggle_navigation') }}</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

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

                <?php /* added the test because sometimes the session exists but the user isn't authenticated */ ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Auth::user()->getAvatarUrl() }}" class="user-image" alt="{{ trans('header.avatar') }}"/>

                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <a href="{{ route('settings.profile') }}">
                                <img src="{{ Auth::user()->getAvatarUrl() }}" class="img-circle" alt="{{ trans('header.avatar') }}" />
                            </a>
                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ trans('header.member_since', ['date' => Auth::user()->created_at->diffForHumans()]) }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            @if (session()->has('campaign_id'))
                            <div class="pull-left">
                                <a href="{{ route('settings.profile') }}" class="btn btn-default btn-flat"> {{ trans('header.profile') }}</a>
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
            </ul>
        </div>
    </nav>
</header>