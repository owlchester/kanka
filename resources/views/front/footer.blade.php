<footer id="footer">
    <div class="container">
        <div class="row footer-links h-100">
            <div class="col-6 col-sm-3">
                <div class="section">
                    <a href="{{ route('home') }}" class="section-title logo">
                        @if(\App\Facades\Img::nowebp())
                            <img src="https://images.kanka.io/app/0HdWv4egPu6lBQ30iWTcS9MPgRo=/64x64/src/images%2Flogos%2Flogo-small-white.png?webpfallback" title="Kanka logo" alt="Kanka logo white" width="48" height="48">
                        @else
                            <img src="https://images.kanka.io/app/0HdWv4egPu6lBQ30iWTcS9MPgRo=/64x64/src/images%2Flogos%2Flogo-small-white.png" title="Kanka logo" alt="Kanka logo white" width="48" height="48">
                        @endif
                    </a>
                </div>

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
                    <li>
                        <a href="//blog.kanka.io" target="_blank">{{ __('front.menu.news') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-sm-3">
                <div class="section">
                    <span class="section-title">
                        {{ __('front.footer.headings.community') }}
                    </span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('community-votes.index') }}">{{ __('front/community-votes.title') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.public_campaigns') }}">{{ __('front.menu.campaigns') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('community-events.index') }}">{{ __('front/community-events.title') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.hall-of-fame') }}">{{ __('front/hall-of-fame.title') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-sm-3">
                <div class="section">
                    <span class="section-title">
                    {{ __('front.footer.headings.useful_links') }}
                    </span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('front.faqs.index') }}">{{ __('front.menu.kb') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('documentation') }}">{{ __('front.menu.documentation') }}</a>
                    </li>
                    <li>
                        <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" target="_blank">{{ __('front.features.api.link') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.contact') }}">{{ __('front.menu.contact') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.media') }}">{{ __('front.menu.media') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-sm-3">
                <div class="section">
                    <span class="section-title">
                        {{ __('front.footer.headings.other') }}
                    </span>
                </div>
                <ul>
                    <li>
                        <a href="//marketplace.kanka.io" target="_blank">{{ __('front.menu.marketplace') }}</a>
                    </li>
                    <li>
                        <a href="//loot.kanka.io" target="_blank">{{ __('front.menu.merch') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.privacy') }}">{{ __('front.menu.privacy') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.terms') }}">{{ __('front.menu.terms') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 footer-socials">
                <div class="email">
                    <i class="fa fa-envelope hidden-xs"></i> hello@kanka.io
                </div>

                <div class="socials">
                    <a href="{{ config('social.discord') }}" target="discord" title="Discord" rel="noreferrer">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="{{ config('social.facebook') }}" target="facebook" title="Facebook" rel="noreferrer">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{ config('social.instagram') }}" target="instagram" title="Instagram" rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ config('social.youtube') }}" target="youtube" title="Youtube" rel="noreferrer">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="{{ config('social.reddit') }}" target="reddit" title="Reddit" rel="noreferrer">
                        <i class="fab fa-reddit"></i>
                    </a>
                    <a href="{{ config('social.twitter') }}" target="twitter" title="Twitter" rel="noreferrer">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center">
            Kanka v{{ config('app.version') }} - {!! __('front.footer.copyright', ['copy' => '&copy;', 'year' => date('Y')])!!} - {{ __('footer.server_time', ['time' => \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm a')]) }}
        </div>
    </div>
</footer>
