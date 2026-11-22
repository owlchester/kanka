<footer id="footer" class="main-footer mt-12 px-6 py-12 print:hidden">
    <div class="mx-auto flex flex-col gap-10 lg:max-w-7xl">
        @if(config('tracking.consent'))
        <div data-cookie-consent-bar style="display: none;" class="rounded-xl bg-base-100 p-4">
            <div class="flex flex-col gap-3 text-sm sm:flex-row sm:items-center">
                <p class="flex-1 text-neutral-content">
                    {{ __('cookieconsent.message') }}
                    <a href="{{ Domain::toFront('privacy-policy') }}" target="_blank" class="text-link">{{ __('cookieconsent.link') }}</a>
                </p>
                <div class="flex shrink-0 gap-2">
                    <button data-accept class="btn2 btn-xs btn-primary">{{ __('cookieconsent.allow') }}</button>
                    <button data-reject class="btn2 btn-xs btn-ghost">{{ __('cookieconsent.reject') }}</button>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-x-8 gap-y-10 md:grid-cols-4 lg:grid-cols-6">
            <div class="col-span-2 flex flex-col gap-4">
                <a href="{{ route('home') }}" class="logo inline-flex w-fit text-link">
                    <svg class="size-11" aria-label="Kanka Logo">
                        <use href="/images/svgs/sprites.svg#kanka-logo"></use>
                    </svg>
                </a>

                <div class="max-w-xs space-y-1.5 text-xs leading-relaxed text-neutral-content">
                    <p>{{ __('footer.humans') }}</p>
                    <p>
                        {!! __('footer.proof', [
                            'community-funded' => '<a href="' . Domain::toFront('hall-of-fame') . '" class="text-base-content/80 underline decoration-base-content/25 underline-offset-2 transition-colors hover:text-primary hover:decoration-primary">community-funded</a>',
                            'source' => '<a href="https://kanka.io/go/github" class="text-base-content/80 underline decoration-base-content/25 underline-offset-2 transition-colors hover:text-primary hover:decoration-primary">core code available on GitHub</a>',
                        ]) !!}
                    </p>
                </div>

                <div class="flex items-center gap-1.5">
                    @include('layouts._socials', ['linkClass' => 'text-neutral-content hover:text-base-content hover:bg-base-content/10'])
                </div>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-base-content">{{ __('footer.platform') }}</span>
                <a href="{{ Domain::toFront('features') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.features') }}</a>
                <a href="{{ Domain::toFront('premium') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.premium') }}</a>
                <a href="{{ Domain::toFront('pricing') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.pricing') }}</a>
                <a href="{{ config('marketplace.url') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.plugins') }}</a>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-base-content">{{ __('footer.resources') }}</span>
                <a href="{{ Domain::toFront('kb') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.kb') }}</a>
                <a href="https://docs.kanka.io/en/latest/index.html" target="_blank" class="group inline-flex w-fit items-center gap-1 text-neutral-content transition-colors hover:text-base-content">
                    {{ __('footer.documentation') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="{{ route('larecipe.index') }}" target="_blank" class="group inline-flex w-fit items-center gap-1 text-neutral-content transition-colors hover:text-base-content">
                    {{ __('front.features.api.link') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="{{ route('mcp.help') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.mcp') }}</a>
                <a href="https://blog.kanka.io" target="_blank" class="group inline-flex w-fit items-center gap-1 text-neutral-content transition-colors hover:text-base-content">
                    {{ __('footer.blog') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="https://status.kanka.io" target="_blank" class="group inline-flex w-fit items-center gap-1 text-neutral-content transition-colors hover:text-base-content">
                    {{ __('footer.status') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-base-content">{{ __('footer.community') }}</span>
                <a href="https://blog.kanka.io/category/news/" target="_blank" class="group inline-flex w-fit items-center gap-1 text-neutral-content transition-colors hover:text-base-content">
                    {{ __('footer.whats-new') }}
                    <span class="text-[10px] opacity-40 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-80" aria-hidden="true">&#8599;</span>
                </a>
                <a href="{{ Domain::toFront('campaigns') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.public-campaigns') }}</a>
                <a href="{{ Domain::toFront('showcase') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.showcase') }}</a>
                <a href="{{ route('roadmap') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.roadmap') }}</a>
                <a href="{{ Domain::toFront('hall-of-fame') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('front/hall-of-fame.title') }}</a>
            </div>

            <div class="flex flex-col gap-2.5 text-sm">
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-base-content">{{ __('footer.company') }}</span>
                <a href="{{ Domain::toFront('about') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.about') }}</a>
                <a href="{{ Domain::toFront('contact') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.contact') }}</a>
                <a href="{{ Domain::toFront('privacy-policy') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.privacy') }}</a>
                <a href="{{ Domain::toFront('terms-and-conditions') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.terms') }}</a>
                <a href="{{ Domain::toFront('security') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.security') }}</a>
                <a href="{{ Domain::toFront('press-kit') }}" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('footer.press-kit') }}</a>
                @if(config('tracking.consent'))
                <a href="#" onclick="window.dispatchEvent(new CustomEvent('show-cookie-consent')); return false;" class="w-fit text-neutral-content transition-colors hover:text-base-content">{{ __('cookieconsent.preferences') }}</a>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap-4 pt-2 text-xs text-neutral-content sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                <span>{!! __('footer.copyright', ['copy' => '&copy;', 'year' => date('Y'), 'company' => 'Owlchester SNC']) !!}</span>
                <span class="opacity-40" aria-hidden="true">&middot;</span>
                <span>Kanka v{{ config('app.version') }}</span>
                <span class="opacity-40" aria-hidden="true">&middot;</span>
                <span data-toggle="tooltip" data-html="true" data-title="{{ __('footer.server-time', ['server' => gethostname()]) }}<br />Page generated in {{ defined('LARAVEL_START') ? round((microtime(true) - LARAVEL_START) * 1000, 2) : 0 }} ms">{{ \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm A') }}</span>
            </div>

            @include('layouts._lang-switcher')
        </div>

        <span data-ccpa-link="1"></span>
        <div id="ncmp-consent-link"></div>
    </div>
</footer>
