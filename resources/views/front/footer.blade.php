<footer id="footer">
    <div class="container">
        <div class="row h-100 footer-links">
            <div class="col-md-3 col-sm-12 col-xs-12 footer-main">
                <div class="row">
                    <div class="col-md-12 col-6">
                        <span>
                            <i class="fa fa-envelope hidden-xs"></i> hello@kanka.io
                        </span>
                    </div>
                    <div class="col-md-12 col-6">
                        <span>
                            {!! __('footer.copyright', ['year' => date('Y')]) !!}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-8 col-8">
                <h4>{{ __('front.footer.navigation') }}</h4>
                <div class="row">
                    <div class="col-lg-4 col-4">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">{{ trans('front.menu.home') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.features') }}">{{ trans('front.menu.features') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.pricing') }}">{{ trans('front.menu.pricing') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.about') }}">{{ trans('front.menu.about') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.news') }}">{{ trans('front.menu.news') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.contact') }}">{{ trans('front.menu.contact') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-4">
                        <ul>
                            <li>
                                <a href="{{ route('front.public_campaigns') }}">{{ trans('front.menu.campaigns') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('faq.index') }}">{{ trans('front.menu.faq') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.help') }}">{{ trans('front.menu.help') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-4">
                        <ul>
                            <li>
                                <a href="{{ route('front.roadmap') }}">{{ trans('front.menu.roadmap') }}</a>
                            </li>
                            <li>
                                <a href="/docs/1.0">{{ trans('front.menu.api') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.privacy') }}">{{ trans('front.menu.privacy') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-4 footer-social">
                <h4>{{ __('front.footer.social') }}</h4>
                <div class="socials">
                    <a href="{{ config('social.discord') }}" target="discord" title="Discord" rel="noreferrer">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="{{ config('social.reddit') }}" target="reddit" title="Reddit" rel="noreferrer">
                        <i class="fab fa-reddit"></i>
                    </a>
                    <a href="{{ config('social.facebook') }}" target="facebook" title="Facebook" rel="noreferrer">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{ config('social.instagram') }}" target="instagram" title="Instagram" rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ config('patreon.url') }}" target="patreon" title="Patreon" rel="noreferrer">
                        <i class="fab fa-patreon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>