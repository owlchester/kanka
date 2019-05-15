<footer id="footer">
    <div class="container">
        <div class="row h-100 footer-links">
            <div class="col-md-3 col-sm-4 col-xs-6">
                <p class="first">
                    <i class="fa fa-envelope hidden-xs"></i> hello@kanka.io
                </p>
                <p>{!! __('footer.copyright', ['year' => date('Y')]) !!}</p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <h4>{{ __('front.footer.navigation') }}</h4>
                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ trans('front.menu.home') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('public_campaigns') }}">{{ trans('front.menu.campaigns') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-2 col-xs-6">
                <h4>{{ __('front.footer.resources') }}</h4>
                <ul>
                    <li>
                        <a href="{{ route('community') }}">{{ trans('front.menu.community') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('faq.index') }}">{{ trans('front.menu.faq') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('help') }}">{{ trans('front.menu.help') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('privacy') }}">{{ trans('front.menu.privacy') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6">
                <h4>{{ __('front.footer.app') }}</h4>
                <ul>
                    <li>
                        <a href="{{ route('about') }}">{{ trans('front.menu.about') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('releases.index') }}">{{ trans('front.menu.releases') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('roadmap') }}">{{ trans('front.menu.roadmap') }}</a>
                    </li>
                    <li>
                        <a href="/docs/1.0">{{ trans('front.menu.api') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 footer-social">
                <h4>{{ __('front.footer.social') }}</h4>
                <ul>
                    <li>
                        <a href="{{ config('patreon.url') }}" target="patreon" title="Patreon" rel="noreferrer">
                            <i class="fab fa-patreon"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ config('discord.url') }}" target="discord" title="Discord" rel="noreferrer"><i class="fab fa-discord"></i></a>
                    </li>
                    <li>
                        <a href="//reddit.com/r/kanka" target="reddit" title="Reddit" rel="noreferrer"><i class="fab fa-reddit"></i></a>
                    </li>
                    <li>
                        <a href="//www.facebook.com/kanka.io.ch" target="facebook" title="Facebook" rel="noreferrer"><i class="fab fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="//twitter.com/kankaio" target="twitter" title="Twitter" rel="noreferrer"><i class="fab fa-twitter"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>