<footer id="footer" class="py-4">
    <div class="container-md">
        <div class="row footer-links h-100 text-left">
            <div class="col-12 col-sm text-truncate text-center mb-2">
                <a href="{{ route('home') }}" class="">
                    <img class="logo-blue" src="https://th.kanka.io/gR8y1nxfEhBC1nVYdQpr2pUW3lY=/48x48/smart/src/app/logos/logo.png" alt="Kanka logo blue" title="Kanka" width="48" height="48" />

                    <img class="logo-white d-none" src="https://th.kanka.io/547r5DZYF2fmdWy9sZztqAnYJN0=/48x48/smart/src/app/logos/logo-small-white.png" title="Kanka logo" alt="Kanka logo" width="48" height="48">
                </a>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.platform') }}
                </div>

                <ul class="list-unstyled">
                    <li>
                        <a href="https://kanka.io/features">{{ __('footer.features') }}</a>
                    </li>
                    @if (config('services.stripe.enabled'))
                    <li>
                        <a href="https://kanka.io/premium">{{ __('footer.premium') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/pricing">{{ __('footer.pricing') }}</a>
                    </li>@endif

                    <li>
                        <a href="https://marketplace.kanka.io" target="_blank">{{ __('footer.marketplace') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.resources') }}
                </div>
                <ul class="list-unstyled">
                    <li>
                        <a href="https://kanka.io/kb">{{ __('footer.kb') }}</a>
                    </li>
                    <li>
                        <a href="//docs.kanka.io/en/latest/index.html" target="_blank">{{ __('footer.documentation') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('larecipe.index') }}" target="_blank">{{ __('front.features.api.link') }}</a>
                    </li>
                    <li>
                        <a href="https://blog.kanka.io/category/news/" target="_blank">{{ __('footer.whats-new') }}</a>
                    </li>
                    <li>
                        <a href="https://blog.kanka.io" target="_blank">{{ __('footer.blog') }}</a>
                    </li>
                    <li>
                        <a href="https://status.kanka.io" target="_blank">{{ __('footer.status') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/newsletter">{{ __('footer.newsletter') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.community') }}
                </div>
                <ul class="list-unstyled">
                    <li>
                        <a href="https://kanka.io/campaigns">{{ __('footer.public-campaigns') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/community-votes">{{ __('front/community-votes.title') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/hall-of-fame">{{ __('front/hall-of-fame.title') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-sm text-truncate mb-2">
                <div class="section mb-2 text-uppcercase">
                    {{ __('footer.company') }}
                </div>
                <ul class="list-unstyled">
                    <li>
                        <a href="https://kanka.io/about">{{ __('footer.about') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/contact">{{ __('footer.contact') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/press-kit">{{ __('footer.press-kit') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/security">{{ __('footer.security') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/privacy-policy">{{ __('footer.privacy') }}</a>
                    </li>
                    <li>
                        <a href="https://kanka.io/terms-and-conditions">{{ __('footer.terms') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="my-4">
            <a href="https://kanka.io/go/discord" class="mr-3" target="discord" title="Discord" rel="noreferrer">
                <i class="fab fa-discord fa-2x" aria-hidden="true"></i>
            </a>
            @if (config('social.facebook'))
            <a href="https://kanka.io/go/facebook" class="mr-3" target="facebook" title="Facebook" rel="noreferrer">
                <i class="fab fa-facebook fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.instagram'))
            <a href="https://kanka.io/go/instagram" class="mr-3" target="instagram" title="Instagram" rel="noreferrer">
                <i class="fab fa-instagram fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.youtube'))
            <a href="https://kanka.io/go/youtube" class="mr-3" target="youtube" title="Youtube" rel="noreferrer">
                <i class="fab fa-youtube fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.reddit'))
            <a href="https://kanka.io/go/reddit" class="mr-3" target="reddit" title="Reddit" rel="noreferrer">
                <i class="fab fa-reddit fa-2x" aria-hidden="true"></i>
            </a>
            @endif
            @if (config('social.twitter'))
            <a href="https://kanka.io/go/twitter" class="mr-3" target="twitter" title="Twitter" rel="noreferrer">
                <i class="fab fa-twitter fa-2x" aria-hidden="true"></i>
            </a>
            @endif
        </div>
        <div class="footer-copyright text-center">
            Kanka {!! __('footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC'])!!}
        </div>
    </div>
</footer>
