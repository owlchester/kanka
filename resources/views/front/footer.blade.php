<footer id="footer">
    <div class="container">
        <div class="row h-100 footer-links">
            <div class="col-lg-2 col-md-2 col-12">
                <h4><a href="{{ route('home') }}">Kanka</a></h4>
            </div>
            <div class="col-lg-7 col-md-7 col-12">
                <div class="row">
                    <div class="col-md-4 col-4">

                        <h5>{{ __('front.footer.headings.app') }}</h5>
                        <ul>
                            <li>
                                <a href="{{ route('front.features') }}">{{ __('front.menu.features') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.pricing') }}">{{ __('front.menu.pricing') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.about') }}">{{ __('front.menu.about') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.newsletter') }}">{{ __('front.menu.newsletter') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-4">
                        <h5>{{ __('front.footer.headings.community') }}</h5>
                        <ul>
                            <li>
                                <a href="{{ route('community-votes.index') }}">{{ __('front/community-votes.title') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.public_campaigns') }}">{{ __('front.menu.campaigns') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-4">
                        <h5>{{ __('front.footer.headings.useful_links') }}</h5>
                        <ul>
                            <li>
                                <a href="{{ route('faq.index') }}">{{ __('front.menu.faq') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.roadmap') }}">{{ __('front.menu.roadmap') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.contact') }}">{{ __('front.menu.contact') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12 footer-social">
                <h4 class="email">
                    <i class="fa fa-envelope hidden-xs"></i> hello@kanka.io
                </h4>

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
                </div>
            </div>
        </div>
        <div class="row secondary-footer">
            <div class="col-md-2"></div>
            <div class="col-md-7 col-12 text-center">
                <ul>
                    <li>
                        <a href="/docs/1.0">{{ __('front.menu.api') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.privacy') }}">{{ __('front.menu.privacy') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.terms') }}">{{ __('front.menu.terms') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-12 text-center">

                <p class="copyright">
                    {!! __('footer.copyright', ['year' => date('Y')]) !!}
                </p>
            </div>

        </div>
    </div>
</footer>
