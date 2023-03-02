<header class="masthead masthead-b">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 my-auto landing-heading lg-text-center">
                @if (in_array(app()->getLocale(), ['en', 'en-US']))
                    <h1 class="ab-testing-a">{{ __('front.master.heading') }}</h1>
                    <h1 class="ab-testing-b">Worldbuilding and RPG campaign management made easy.</h1>
                @else
                    <h1 class="">{{ __('front.master.heading') }}</h1>
                @endif
            </div>
            <div class="col-lg-7">
                <div class="header-content text-left text-lg-center ab-testing-a">
                    <p class="mb-5">{{ __('front.master.description', ['kanka' => config('app.name')]) }}</p>
                    @if (config('auth.register_enabled'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            {{ __('front.second_block.call_to_action') }}
                        </a>
                    @endif
                </div>
                <div class="header-content text-left ab-testing-b">
                    @if (in_array(app()->getLocale(), ['en', 'en-US']))
                    <p class="mb-5 ab-testing-b">{{ __('front.master.description_q1_2023', ['kanka' => config('app.name')]) }}</p>
                    @else
                    <p class="mb-5">{{ __('front.master.description', ['kanka' => config('app.name')]) }}</p>
                    @endif
                    @if (config('auth.register_enabled'))
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        {{ __('front.second_block.call_to_action') }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div class="youtube-placeholder ab-testing-b" data-yt-url="https://www.youtube.com/embed/ZWVf7JAWKPg">
                    <img src="https://images.kanka.io/app/lZxyUzYrY4SuB49YgDwlK2vnx4M=/445x253/smart/src/images%2Ffront%2Fplay-youtube-3.png" async loading="lazy" class="play-youtube-video" alt="Youtube video" title="What is Kanka?" width="445" height="253" >
                </div>
                <div class="youtube-placeholder ab-testing-a" data-yt-url="https://www.youtube.com/embed/ZWVf7JAWKPg">
                    <div class="youtube-placeholder" data-yt-url="https://www.youtube.com/embed/ZWVf7JAWKPg">
                        <img src="https://images.kanka.io/app/O--WZGtZVhlrzMWmTDXepBGTa6c=/445x253/src/images%2Ffront%2Fplay-youtube.jpg" async loading="lazy" class="play-youtube-video" alt="Youtube video" title="What is Kanka?" width="445" height="253" >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</header>
