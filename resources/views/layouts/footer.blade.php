<footer id="footer" class="main-footer px-4 py-10 print:hidden">
    <div class="lg:max-w-7xl lg:mx-auto">
        <div class="flex flex-col gap-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
                <div class="flex-col gap-4 hidden lg:flex col-span-2 ">
                    <div class="flex">
                        <a href="{{ route('home') }}" class="logo text-link">
                            <svg class="h-28 w-28"  alt="Kanka Logo" >
                                <use href="/images/svgs/sprites.svg#kanka-logo" fill="red"></use>
                            </svg>
                        </a>
                    </div>


                    <div class="flex items-center gap-5 text-3xl flex-wrap">
                        @include('layouts._socials')
                    </div>

                    @include('layouts._lang-switcher')

                    <div class="text-xs text-neutral-content">
                        <p>
                            {{ __('footer.made') }}
                        </p>
                        <p>
                            {{ __('footer.thanks') }}
                        </p>
                        <p>
                            {!! __('footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC'])!!}
                        </p>
                    </div>

                    <div class="text-xs text-neutral-content">
                        <p>
                            Kanka v{{ config('app.version') }} - <span data-toggle="tooltip" data-html="true" data-title="{{ __('footer.server-time', ['server' => gethostname()]) }}<br />Page generated in {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }} ms">{{ \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm A') }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.platform') }}</span>
                    <a href="{{ Domain::toFront('features') }}" class="text-link">{{ __('footer.features') }}</a>
                    <a href="{{ Domain::toFront('premium') }}" class="text-link">{{ __('footer.premium') }}</a>
                    <a href="{{ Domain::toFront('pricing') }}" class="text-link">{{ __('footer.pricing') }}</a>
                    <a href="{{ config('marketplace.url') }}" class="text-link">{{ __('footer.plugins') }}</a>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.resources') }}</span>
                    <a href="{{ Domain::toFront('kb') }}" class="text-link">{{ __('footer.kb') }}</a>
                    <a href="https://docs.kanka.io/en/latest/index.html" target="_blank" class="text-link">{{ __('footer.documentation') }}</a>
                    <a href="{{ route('larecipe.index') }}" target="_blank" class="text-link">{{ __('front.features.api.link') }}</a>
                    <a href="https://blog.kanka.io" target="_blank" class="text-link">{{ __('footer.blog') }}</a>
                    <a href="https://status.kanka.io" target="_blank" class="text-link">{{ __('footer.status') }}</a>
                    <a href="{{ Domain::toFront('newsletter') }}" class="text-link">{{ __('footer.newsletter') }}</a>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.community') }}</span>
                    <a href="https://blog.kanka.io/category/news/" class="text-link" target="_blank">{{ __('footer.whats-new') }}</a>
                    <a href="{{ Domain::toFront('campaigns') }}" class="text-link">{{ __('footer.public-campaigns') }}</a>
                    <a href="{{ route('roadmap') }}" class="text-link">{{ __('footer.roadmap') }}</a>
                    <a href="{{ Domain::toFront('hall-of-fame') }}" class="text-link">{{ __('front/hall-of-fame.title') }}</a>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.company') }}</span>
                    <a href="{{ Domain::toFront('about') }}" class="text-link">{{ __('footer.about') }}</a>
                    <a href="{{ Domain::toFront('contact') }}" class="text-link">{{ __('footer.contact') }}</a>
                    <a href="{{ Domain::toFront('privacy-policy') }}" class="text-link">{{ __('footer.privacy') }}</a>
                    <a href="{{ Domain::toFront('terms-and-conditions') }}" class="text-link">{{ __('footer.terms') }}</a>
                    <a href="{{ Domain::toFront('security') }}" class="text-link">{{ __('footer.security') }}</a>
                    <a href="{{ Domain::toFront('press-kit') }}" class="text-link">{{ __('footer.press-kit') }}</a>
                </div>
            </div>
            <div class="lg:hidden flex flex-col gap-5 text-center">
                <div class="logo text-center">
                    <div class="inline-block">
                        <a href="{{ route('home') }}" class="logo text-link">

                            <svg class="h-28 w-28" alt="Kanka Logo" >
                                <use href="/images/svgs/sprites.svg#kanka-logo"></use>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="flex justify-center gap-5 text-3xl">
                    @include('layouts._socials')
                </div>

                @include('layouts._lang-switcher')

                <div class="text-center text-sm">

                    <p>Kanka v{{ config('app.version') }} - {!! __('footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC'])!!}</p>

                    <p>{{ \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm a') }} ({{ gethostname() }})</p>
                </div>
            </div>
            <span data-ccpa-link="1"></span>
            <div id="ncmp-consent-link"></div>
        </div>
    </div>
</footer>
