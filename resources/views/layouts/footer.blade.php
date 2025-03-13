<footer id="footer" class="main-footer px-4 py-10">
    <div class="lg:max-w-7xl lg:mx-auto">
        <div class="flex flex-col gap-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
                <div class="flex-col gap-4 hidden lg:flex col-span-2 ">
                    <a href="{{ route('home') }}" class="logo">
                        @include('icons.kanka-svg')
                    </a>


                    <div class="flex items-center gap-5 text-3xl flex-wrap">
                        @include('layouts._socials')
                    </div>

                    @include('layouts._lang-switcher')

                    <div class="text-xs">
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

                    <div class="text-xs">
                        <p>
                            Kanka v{{ config('app.version') }} - <span data-toggle="tooltip" data-title="{{ __('footer.server-time', ['server' => gethostname()]) }}">{{ \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm A') }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.platform') }}</span>
                    <a href="{{ Domain::toFront('features') }}">{{ __('footer.features') }}</a>
                    <a href="{{ Domain::toFront('premium') }}">{{ __('footer.premium') }}</a>
                    <a href="{{ Domain::toFront('pricing') }}">{{ __('footer.pricing') }}</a>
                    <a href="{{ config('marketplace.url') }}">{{ __('footer.plugins') }}</a>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.resources') }}</span>
                    <a href="{{ Domain::toFront('kb') }}">{{ __('footer.kb') }}</a>
                    <a href="https://docs.kanka.io/en/latest/index.html" target="_blank">{{ __('footer.documentation') }}</a>
                    <a href="{{ route('larecipe.index') }}" target="_blank">{{ __('front.features.api.link') }}</a>
                    <a href="https://blog.kanka.io" target="_blank">{{ __('footer.blog') }}</a>
                    <a href="https://status.kanka.io" target="_blank">{{ __('footer.status') }}</a>
                    <a href="{{ Domain::toFront('newsletter') }}">{{ __('footer.newsletter') }}</a>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.community') }}</span>
                    <a href="https://blog.kanka.io/category/news/" target="_blank">{{ __('footer.whats-new') }}</a>
                    <a href="{{ Domain::toFront('campaigns') }}">{{ __('footer.public-campaigns') }}</a>
                    <a href="{{ route('roadmap') }}">{{ __('footer.roadmap') }}</a>
                    <a href="{{ Domain::toFront('hall-of-fame') }}">{{ __('front/hall-of-fame.title') }}</a>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <span class="block text-nav uppercase">{{ __('footer.company') }}</span>
                    <a href="{{ Domain::toFront('about') }}">{{ __('footer.about') }}</a>
                    <a href="{{ Domain::toFront('contact') }}">{{ __('footer.contact') }}</a>
                    <a href="{{ Domain::toFront('privacy-policy') }}">{{ __('footer.privacy') }}</a>
                    <a href="{{ Domain::toFront('terms-and-conditions') }}">{{ __('footer.terms') }}</a>
                    <a href="{{ Domain::toFront('security') }}">{{ __('footer.security') }}</a>
                    <a href="{{ Domain::toFront('press-kit') }}">{{ __('footer.press-kit') }}</a>
                </div>
            </div>
            <div class="lg:hidden flex flex-col gap-5 text-center">
                <div class="logo text-center">
                    <div class="inline-block">
                        @include('icons.kanka-svg')
                    </div>
                </div>

                <div class="flex justify-center gap-5 text-3xl">
                    @include('layouts._socials')
                </div>

                @include('layouts._lang-switcher')

                <div class="text-center text-sm">
                    Kanka v{{ config('app.version') }} - {!! __('footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC'])!!} - {{ __('footer.server_time', ['time' => \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm a')]) }} ({{ gethostname() }})
                </div>
            </div>
        </div>
    </div>
</footer>
