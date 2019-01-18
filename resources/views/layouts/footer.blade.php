<!-- Main Footer -->
<footer id="footer" class="main-footer">
    <div class="footer">

        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <span><i class="fa fa-envelope"></i> hello@kanka.io</span>
            </div>
            <div class="col-sm-4 col-xs-4">
                <span>{!! __('footer.copyright', ['year' => date('Y')]) !!}</span>
            </div>
            <div class="col-sm-4 col-xs-4">
                <ul class="social">
                    <li>
                        <a href="//www.patreon.com/kankaio" target="patreon" title="Patreon" rel="noreferrer">
                            <i class="fab fa-patreon"></i>
                        </a>
                    </li>
                    <li>
                        <a href="//discord.gg/rhsyZJ4" target="discord" title="Discord" rel="noreferrer"><i class="fab fa-discord"></i></a>
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
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
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
            <div class="col-md-4 col-sm-4 col-xs-4">
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
            <div class="col-md-4 col-sm-4 col-xs-4">
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
                </ul>
            </div>
        </div>
    </div>
</footer>
