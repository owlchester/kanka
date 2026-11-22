<footer class="bg-dark text-light px-6 py-14">
    <div class="mx-auto flex flex-col gap-10 lg:max-w-7xl">
        @if(config('tracking.consent'))
        <div data-cookie-consent-bar style="display: none;" class="rounded-lg border border-white/10 bg-white/5 p-4">
            <div class="flex flex-col gap-3 text-sm sm:flex-row sm:items-center">
                <p class="flex-1 text-white/70">
                    {{ __('cookieconsent.message') }}
                    <a href="{{ Domain::toFront('privacy-policy') }}" target="_blank" class="text-blue-400 hover:underline">{{ __('cookieconsent.link') }}</a>
                </p>
                <div class="flex shrink-0 gap-2">
                    <button data-accept class="rounded bg-blue-600 px-3 py-1 text-xs font-medium text-white hover:bg-blue-700">{{ __('cookieconsent.allow') }}</button>
                    <button data-reject class="rounded border border-white/20 px-3 py-1 text-xs text-white/60 hover:border-white/40">{{ __('cookieconsent.reject') }}</button>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-x-8 gap-y-10 md:grid-cols-4 lg:grid-cols-6">
            <div class="col-span-2 flex flex-col gap-4">
                <a href="{{ route('home') }}" class="inline-flex w-fit text-white">
                    <svg class="size-11" aria-label="Kanka Logo">
                        <use href="/images/svgs/sprites.svg#kanka-logo"></use>
                    </svg>
                </a>

                <p class="max-w-xs text-xs leading-relaxed text-white/65">
                    {{ __('footer.humans') }}
                </p>

                <div class="flex items-center gap-1.5">
                    @include('layouts._socials', ['linkClass' => 'text-white/70 hover:text-white hover:bg-white/10'])
                </div>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-white">{{ __('footer.platform') }}</span>
                <a href="{{ Domain::toFront('features') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.features') }}</a>
                <a href="{{ Domain::toFront('premium') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.premium') }}</a>
                <a href="{{ Domain::toFront('pricing') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.pricing') }}</a>
                <a href="{{ config('marketplace.url') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.plugins') }}</a>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-white">{{ __('footer.resources') }}</span>
                <a href="{{ Domain::toFront('kb') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.kb') }}</a>
                <a href="https://docs.kanka.io/en/latest/index.html" target="_blank" class="group inline-flex w-fit items-center gap-1 text-white/65 transition-colors hover:text-white">
                    {{ __('footer.documentation') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="{{ route('larecipe.index') }}" target="_blank" class="group inline-flex w-fit items-center gap-1 text-white/65 transition-colors hover:text-white">
                    {{ __('front.features.api.link') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="{{ route('mcp.help') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.mcp') }}</a>
                <a href="https://blog.kanka.io" target="_blank" class="group inline-flex w-fit items-center gap-1 text-white/65 transition-colors hover:text-white">
                    {{ __('footer.blog') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="https://status.kanka.io" target="_blank" class="group inline-flex w-fit items-center gap-1 text-white/65 transition-colors hover:text-white">
                    {{ __('footer.status') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-white">{{ __('footer.community') }}</span>
                <a href="https://blog.kanka.io/category/news" target="_blank" class="group inline-flex w-fit items-center gap-1 text-white/65 transition-colors hover:text-white">
                    {{ __('footer.whats-new') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="{{ Domain::toFront('campaigns') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.public-campaigns') }}</a>
                <a href="{{ Domain::toFront('showcase') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.showcase') }}</a>
                <a href="{{ route('roadmap') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.roadmap') }}</a>
                <a href="{{ Domain::toFront('hall-of-fame') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('front/hall-of-fame.title') }}</a>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-white">{{ __('footer.company') }}</span>
                <a href="{{ Domain::toFront('about') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.about') }}</a>
                <a href="{{ Domain::toFront('contact') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.contact') }}</a>
                <a href="{{ Domain::toFront('privacy-policy') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.privacy') }}</a>
                <a href="{{ Domain::toFront('terms-and-conditions') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.terms') }}</a>
                <a href="{{ Domain::toFront('security') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.security') }}</a>
                <a href="{{ Domain::toFront('press-kit') }}" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('footer.press-kit') }}</a>
                @if(config('tracking.consent'))
                <a href="#" onclick="window.dispatchEvent(new CustomEvent('show-cookie-consent')); return false;" class="w-fit text-white/65 transition-colors hover:text-white">{{ __('cookieconsent.preferences') }}</a>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap-3 pt-2 text-xs text-white/55 sm:flex-row sm:items-center sm:justify-between">
            <p>
                {!! __('footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC']) !!}
            </p>
            <p>
                {!! __('footer.proof', [
                    'community-funded' => '<a href="' . Domain::toFront('hall-of-fame') . '" class="text-white/80 underline decoration-white/30 underline-offset-2 transition-colors hover:text-white hover:decoration-white">community-funded</a>',
                    'source' => '<a href="https://kanka.io/go/github" class="text-white/80 underline decoration-white/30 underline-offset-2 transition-colors hover:text-white hover:decoration-white">core code available on GitHub</a>',
                ]) !!}
            </p>
        </div>

        <span data-ccpa-link="1"></span>
        <div id="ncmp-consent-link"></div>
    </div>
</footer>
