<!-- Main Footer -->
<footer id="footer" class="main-footer">
    <div class="translator-call text-center hidden-xs">
        <p class="text-muted">{!! __('footer.translator_call', ['discord' => link_to(config('discord.url'), 'Discord', ['target' => '_blank'])]) !!}</p>
    </div>
    <div class="footer">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-xs-12 text-center">
                <h4 class="margin-bottom"><a href="{{ route('home') }}">
                    @if(\App\Facades\Img::nowebp())
                        <img class="logo-blue" src="https://images.kanka.io/app/DEy2otI4qKGIJHMX_JFxeEFGRls=/64x64/src/images%2Flogos%2Flogo-small.png?webpfallback" alt="Kanka logo blue" title="Kanka" />
                        <img class="logo-white" src="https://images.kanka.io/app/0HdWv4egPu6lBQ30iWTcS9MPgRo=/64x64/src/images%2Flogos%2Flogo-small-white.png?webpfallback" alt="Kanka logo white" title="Kanka" />
                    @else
                        <img class="logo-blue" src="https://images.kanka.io/app/DEy2otI4qKGIJHMX_JFxeEFGRls=/64x64/src/images%2Flogos%2Flogo-small.png" alt="Kanka logo blue" title="Kanka" />
                        <img class="logo-white" src="https://images.kanka.io/app/0HdWv4egPu6lBQ30iWTcS9MPgRo=/64x64/src/images%2Flogos%2Flogo-small-white.png" alt="Kanka logo white" title="Kanka" />
                    @endif
                </a></h4>
            </div>
            <div class="col-lg-7 col-md-7 col-xs-12">
                <div class="row">
                    <div class="col-lg-4 col-xs-4">
                        <h5>{{ __('front.footer.headings.app') }}</h5>
                        <ul class="margin-bottom">
                            <li>
                                <a href="{{ route('front.features') }}">{{ __('front.menu.features') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.pricing') }}">{{ __('front.menu.pricing') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.about') }}">{{ __('front.menu.about') }}</a>
                            </li>
                        </ul>

                        <h5>{{ __('front.footer.headings.community') }}</h5>
                        <ul>
                            <li>
                                <a href="{{ route('community-votes.index') }}">{{ __('front/community-votes.title') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('community-events.index') }}">{{ __('front/community-events.title') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('front.public_campaigns') }}">{{ __('front.menu.campaigns') }}</a>
                            </li>
                            <li>
                                <a href="https://blog.kanka.io">{{ __('front.menu.news') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-xs-4">
                        <h5>{{ __('front.footer.headings.useful_links') }}</h5>
                        <ul class="margin-bottom">
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
                        <ul>
                            <li>
                                <a href="https://marketplace.kanka.io">{{ __('front.menu.marketplace') }}</a>
                            </li>
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
                    <div class="col-lg-4 col-xs-4">
                        <h5>{{ __('front.footer.headings.friends') }}</h5>
                        <ul>
                            <li>
                                <a href="//lookingforgm.com?utm_source=kanka_footer_app" target="_blank" title="LookingForGM.com">LFGM</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 footer-social">
                <h4 class="email">
                    <i class="fa fa-envelope"></i> hello@kanka.io
                </h4>
                <div class="socials">
                    <a href="{{ config('social.discord') }}" target="discord" rel="nofollow" title="Discord" rel="noreferrer">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="{{ config('social.twitch') }}" target="twitch" rel="nofollow" title="Twitch" rel="noreferrer">
                        <i class="fab fa-twitch"></i>
                    </a>
                    <a href="{{ config('social.facebook') }}" target="facebook" rel="nofollow" title="Facebook" rel="noreferrer">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{ config('social.instagram') }}" target="instagram" rel="nofollow" title="Instagram" rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ config('social.reddit') }}" target="reddit" rel="nofollow" title="Reddit" rel="noreferrer">
                        <i class="fab fa-reddit"></i>
                    </a>
                </div>

                <div class="copyright">
                    <div class="dropup">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="languageDropdown" aria-haspopup="true" aria-expanded="false" name="list-languages">
                            <i class="fas fa-globe"></i> {{ LaravelLocalization::getCurrentLocaleNative() }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="secondary-footer text-center">
            <p class="copyright">
                Kanka v{{ config('app.version') }} - {!! __('footer.copyright', ['year' => date('Y')]) !!} - {{ __('footer.server_time', ['time' => \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm a')]) }}
            </p>
        </div>
    </div>
</footer>
