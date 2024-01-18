<nav class="flex items-center justify-between gap-16 lg:gap-20 h-32 px-5 max-w-7xl mx-auto">
    <a href="/">
        <img src="https://th.kanka.io/d4ZF6X-TrBX2HwsAYM_fNo8W2PA=/103x103/smart/src/app/logos/logo.png" title="Kanka logo" alt="Kanka" />
    </a>
    <div class="gap-8 lg:gap-12 items-center grow hidden lg:flex">
        <a href="//{{ config('domains.front') }}/features" class="link text-nav">
            {{ __('footer.features') }}
        </a>
        <a href="//{{ config('domains.front') }}/pricing" class="link text-nav">
            {{ __('footer.pricing') }}
        </a>
        <a href="//{{ config('domains.front') }}/campaigns" class="link text-nav">
            {{ __('footer.public-campaigns') }}
        </a>
    </div>

    @if (!isset($minimal) || !$minimal)
    <div class="gap-2.5 items-center hidden lg:flex">
        @guest()
            <a href="{{ route('login') }}" class="btn-login transition-all duration-200">
                {{ __('front.menu.login') }}
            </a>
            @if (config('auth.register_enabled'))
            <a href="{{ route('register') }}" class="btn-register transition-all duration-200">
                {{ __('front.menu.register') }}
            </a>
            @endif
        @else
            <a href="{{ route('home') }}" class="btn-register transition-all duration-200">
                {{ __('front.menu.dashboard') }}
            </a>
        @endif
    </div>
    @endif
    <div class="block lg:hidden text-5xl text-blue" id="nav-mobile-toggler">
        <div class="cursor-pointer open" aria-label="Open menu">
            <i class="fa-thin fa-bars" aria-hidden="true"></i>
        </div>
        <div class="cursor-pointer close" aria-label="Close menu">
            <i class="fa-thin fa-times" aria-hidden="true"></i>
        </div>

        <div class="mobile-menu fixed top-0 bottom-0 left-0 right-0 px-5 w-full bg-white">
            <div class="h-32 flex justify-end items-center">
                <i class="fa-thin fa-times text-5xl text-blue cursor-pointer"></i>
            </div>
            <div class="px-16 flex flex-col gap-6 items-center">
                @auth()
                    <a href="/" class="link text-nav">
                        {{ __('front.menu.dashboard') }}
                    </a>
                @endif
                <a href="https://kanka.io/features" class="link text-nav">
                    {{ __('footer.features') }}
                </a>
                <a href="https://kanka.io/pricing" class="link text-nav">
                    {{ __('footer.pricing') }}
                </a>
                <a href="https://kanka.io/campaigns" class="link text-nav">
                    {{ __('footer.public-campaigns') }}
                </a>


                @if (!isset($minimal) || !$minimal)
                    @guest()
                        <a href="{{ route('login') }}" class="btn-login transition-all duration-200">
                            {{ __('front.menu.login') }}
                        </a>
                        @if (config('auth.register_enabled'))
                        <a href="{{ route('register') }}" class="btn-register transition-all duration-200">
                            {{ __('front.menu.register') }}
                        </a>
                        @endif
                    @else
                        <a href="{{ route('home') }}" class="btn-register transition-all duration-200">
                            {{ __('front.menu.dashboard') }}
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
