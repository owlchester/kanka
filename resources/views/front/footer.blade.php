<footer id="footer" class="py-4">
    <div class="container-md">
        <div class="row footer-links h-100 text-left">
            <div class="col-12 col-sm text-truncate text-center mb-2">
                <a href="{{ route('home') }}" class="">
                    <img class="logo-blue" src="https://th.kanka.io/wj726mGfu-qAwU_QpAbMYIctM7w=/48x48/smart/app/logos/logo.png" alt="Kanka logo blue" title="Kanka" width="48" height="48" />

                    <img class="logo-white d-none" src="https://th.kanka.io/tjrF04vnk_lUb2Dzu4QgOPAcku8=/48x48/smart/app/logos/logo-small-white.png" title="Kanka logo" alt="Kanka logo" width="48" height="48">
                </a>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.platform') }}
                </div>

                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('front.features') }}">{{ __('front.menu.features') }}</a>
                    </li>
                    @if (config('services.stripe.enabled'))
                    <li>
                        <a href="{{ route('front.premium') }}">{{ __('footer.premium') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.pricing') }}">{{ __('front.menu.pricing') }}</a>
                    </li>@endif

                    <li>
                        <a href="//marketplace.kanka.io" target="_blank">{{ __('front.menu.marketplace') }}</a>
                    </li>
                    <!--<li>
                        <a href="//loot.kanka.io" target="_blank">{{ __('front.menu.merch') }}</a>
                    </li>-->
                </ul>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.resources') }}
                </div>
                <ul class="list-unstyled">
                    @if(config('app.admin'))
                        <li>
                            <a href="{{ route('front.faqs.index') }}">{{ __('front.menu.kb') }}</a>
                        </li>
                    @endif
                    <li>
                        <a href="//docs.kanka.io/en/latest/index.html" target="_blank">{{ __('front.menu.documentation') }}</a>
                    </li>
                    <li>
                        <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" target="_blank">{{ __('front.features.api.link') }}</a>
                    </li>

                    <li>
                        <a href="//blog.kanka.io/category/news/" target="_blank">{{ __('footer.whats-new') }}</a>
                    </li>
                    <li>
                        <a href="//blog.kanka.io" target="_blank">{{ __('footer.blog') }}</a>
                    </li>
                    @if (config('services.stripe.enabled'))
                            <li>
                                <a href="//status.kanka.io" target="_blank">{{ __('footer.status') }}</a>
                            </li>
                    <li>
                        <a href="{{ route('front.newsletter') }}">{{ __('front.menu.newsletter') }}</a>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('front.footer.headings.community') }}
                </div>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('front.public_campaigns') }}">{{ __('front.menu.campaigns') }}</a>
                    </li>
                    @if (config('services.stripe.enabled') && config('app.admin'))<li>
                        <a href="{{ route('community-votes.index') }}">{{ __('front/community-votes.title') }}</a>
                    </li>@endif
                    @if(config('app.admin'))
                    <li>
                        <a href="{{ route('community-events.index') }}">{{ __('front/community-events.title') }}</a>
                    </li>
                    @endif
                    @if (config('services.stripe.enabled'))<li>
                        <a href="{{ route('front.hall-of-fame') }}">{{ __('front/hall-of-fame.title') }}</a>
                    </li>@endif
                </ul>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.company') }}
                </div>
                <ul class="list-unstyled">
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

        <div class="my-4">
            <a href="{{ config('social.discord') }}" class="mr-3" target="discord" title="Discord" rel="noreferrer">
                <i class="fab fa-discord fa-2x" aria-hidden="true"></i>
            </a>
            @if (config('social.facebook'))
            <a href="{{ config('social.facebook') }}" class="mr-3" target="facebook" title="Facebook" rel="noreferrer">
                <i class="fab fa-facebook fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.instagram'))
            <a href="{{ config('social.instagram') }}" class="mr-3" target="instagram" title="Instagram" rel="noreferrer">
                <i class="fab fa-instagram fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.youtube'))
            <a href="{{ config('social.youtube') }}" class="mr-3" target="youtube" title="Youtube" rel="noreferrer">
                <i class="fab fa-youtube fa-2x" aria-hidden="true"></i>
            </a>
            @if (config('social.reddit'))
            <a href="{{ config('social.reddit') }}" class="mr-3" target="reddit" title="Reddit" rel="noreferrer">
                <i class="fab fa-reddit fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.twitter'))
            <a href="{{ config('social.twitter') }}" class="mr-3" target="twitter" title="Twitter" rel="noreferrer">
                <i class="fab fa-twitter fa-2x" aria-hidden="true"></i>
            </a>
            @endif
        </div>
        <div class="footer-copyright text-center">
            Kanka v{{ config('app.version') }} - {!! __('front.footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC'])!!} - {{ __('footer.server_time', ['time' => \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm a')]) }}
        </div>
    </div>
</footer>
