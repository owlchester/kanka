<!-- Main Footer -->
<footer id="footer" class="main-footer">
    @ads('footer')
    <div class="ads-space">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ config('tracking.adsense') }}"
             data-ad-slot="{{ config('tracking.adsense_footer') }}"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    @endads

    <div class="footer-links">
        <div class="grid gap-2 grid-cols-2 md:grid-cols-5">
            <div class="col-span-2 md:col-auto text-center">
                <a href="{{ route('home') }}" class="logo mb-5">
                    @if(\App\Facades\Img::nowebp())
                        <img class="logo-blue" src="https://images.kanka.io/app/DEy2otI4qKGIJHMX_JFxeEFGRls=/64x64/src/images%2Flogos%2Flogo-small.png?webpfallback" alt="Kanka logo blue" title="Kanka" width="48" height="48" />
                        <img class="logo-white" src="https://images.kanka.io/app/0HdWv4egPu6lBQ30iWTcS9MPgRo=/64x64/src/images%2Flogos%2Flogo-small-white.png?webpfallback" alt="Kanka logo white" title="Kanka" width="48" height="48" />
                    @else
                        <img class="logo-blue" src="https://images.kanka.io/app/DEy2otI4qKGIJHMX_JFxeEFGRls=/64x64/src/images%2Flogos%2Flogo-small.png" alt="Kanka logo blue" title="Kanka" width="48" height="48" />
                        <img class="logo-white" src="https://images.kanka.io/app/0HdWv4egPu6lBQ30iWTcS9MPgRo=/64x64/src/images%2Flogos%2Flogo-small-white.png" alt="Kanka logo white" title="Kanka" width="48" height="48" />
                    @endif
                </a>
            </div>
            <div class="cell">
                <h5 class="text-uppercase my-0">
                    {{ __('footer.platform') }}
                </h5>

                <ul>
                    <li>
                        <a href="{{ route('front.features') }}">{{ __('front.menu.features') }}</a>
                    </li>
                    @if (config('services.stripe.enabled'))
                    <li>
                        <a href="{{ route('front.boosters') }}">{{ __('footer.boosters') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.pricing') }}">{{ __('front.menu.pricing') }}</a>
                    </li>
                    @endif

                    <li>
                        <a href="//marketplace.kanka.io" target="_blank">{{ __('front.menu.marketplace') }}</a>
                    </li>
                    <li>
                        <a href="//loot.kanka.io" target="_blank">{{ __('front.menu.merch') }}</a>
                    </li>
                </ul>
            </div>
            <div class="cell">
                <h5 class="text-uppercase my-0">
                    {{ __('footer.resources') }}
                </h5>
                <ul>
                    @if(config('app.admin'))<li>
                        <a href="{{ route('front.faqs.index') }}">{{ __('front.menu.kb') }}</a>
                    </li>@endif
                    <li>
                        <a href="{{ route('documentation') }}">{{ __('front.menu.documentation') }}</a>
                    </li>
                    @if(config('app.admin'))
                    <li>
                        <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" target="_blank">{{ __('front.features.api.link') }}</a>
                    </li>
                    @endif
                        <li>
                            <a href="//blog.kanka.io/categories/news" target="_blank">{{ __('footer.whats-new') }}</a>
                        </li>
                        <li>
                            <a href="//blog.kanka.io" target="_blank">{{ __('footer.blog') }}</a>
                        </li>

                    @if (config('services.stripe.enabled'))
                    <li>
                        <a href="{{ route('front.newsletter') }}">{{ __('front.menu.newsletter') }}</a>
                    </li>
                    @endif

                </ul>
            </div>

            <div class="cell">
                <h5 class="text-uppercase my-0">
                    {{ __('front.footer.headings.community') }}
                </h5>
                <ul>
                    <li>
                        <a href="{{ route('front.public_campaigns') }}">{{ __('front.menu.campaigns') }}</a>
                    </li>
                    @if(config('app.admin'))
                        <li>
                            <a href="{{ route('community-votes.index') }}">{{ __('front/community-votes.title') }}</a>
                        </li>
                    @endif
                    @if(config('app.admin'))
                        <li>
                            <a href="{{ route('community-events.index') }}">{{ __('front/community-events.title') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('front.hall-of-fame') }}">{{ __('front/hall-of-fame.title') }}</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ config('social.discord') }}" target="discord" title="Discord" rel="noreferrer">
                            Discord
                        </a>
                    </li>
                </ul>
            </div>

            <div class="cell">
                <h5 class="text-uppercase my-0">
                    {{ __('footer.company') }}
                </h5>
                <ul>
                    <li>
                        <a href="{{ route('front.about') }}">{{ __('front.menu.about') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.contact') }}">{{ __('front.menu.contact') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.press-kit') }}">{{ __('footer.press-kit') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.security') }}">{{ __('footer.security') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.privacy') }}">{{ __('footer.privacy') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.terms') }}">{{ __('footer.terms') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-socials text-center">
            <div class="email">
                <i class="fa-solid fa-envelope hidden-xs"></i> {{ config('app.email') }}
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

            <div id="language-switcher" class="language-switcher">
                <a href="#" class="" data-toggle="dialog" data-target="language-select-modal">
                    <i class="fa-solid fa-language"></i> {{ LaravelLocalization::getCurrentLocaleNative() }} (Switch)
                </a>
            </div>
        </div>
        <div class="footer-copyright text-center">
            Kanka v{{ config('app.version') }} - {!! __('front.footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC'])!!} - {{ __('footer.server_time', ['time' => \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm a')]) }} ({{ gethostname() }})
        </div>
    </div>
</footer>

<dialog class="dialog rounded-2xl" id="language-select-modal">
    <header>
        <h4>
            <i class="fa-solid fa-language"></i> {{ __('Select your language') }}
        </h4>
        <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </button>
    </header>
    <article>
        <div class="grid grid-cols-2 gap-4">
            <ul class="list-unstyled">
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('en-US', null, [], true); @endphp
                    <a rel="alternate" hreflang="en-US" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        US English
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('en', null, [], true); @endphp
                    <a rel="alternate" hreflang="en" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        UK English
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('pt-BR', null, [], true); @endphp
                    <a rel="alternate" hreflang="pt-BR" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Português do Brasil
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('de', null, [], true); @endphp
                    <a rel="alternate" hreflang="de" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Deutsch
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('es', null, [], true); @endphp
                    <a rel="alternate" hreflang="es" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Español
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('fr', null, [], true); @endphp
                    <a rel="alternate" hreflang="fr" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Français
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('it', null, [], true); @endphp
                    <a rel="alternate" hreflang="it" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Italiano
                    </a>
                </li>
            </ul>
            <ul class="list-unstyled">
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('ru', null, [], true); @endphp
                    <a rel="alternate" hreflang="ru" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Pусский
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('pl', null, [], true); @endphp
                    <a rel="alternate" hreflang="pl" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Polska
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('nl', null, [], true); @endphp
                    <a rel="alternate" hreflang="nl" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Nederlands
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('hu', null, [], true); @endphp
                    <a rel="alternate" hreflang="hu" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Magyar
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('ca', null, [], true); @endphp
                    <a rel="alternate" hreflang="ca" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Català
                    </a>
                </li>
                <li class="py-2">
                    @php $url = LaravelLocalization::getLocalizedURL('sk', null, [], true); @endphp
                    <a rel="alternate" hreflang="sk" href="{{ $url . (strpos($url, '?') !== false ? '&' : '?') }}updateLocale=true">
                        Slovenský
                    </a>
                </li>
            </ul>
        </div>
    </article>
</dialog>
