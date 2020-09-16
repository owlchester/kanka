<header class="masthead masthead-img @nowebp webpfallback @endnowebp">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 my-auto landing-heading">
                <h1 class="">{{ trans('front.master.heading') }}</h1>
            </div>
            <div class="col-lg-7">
                <div class="header-content">
                    <p class="mb-5">{{ trans('front.master.description') }}</p>
                    @if(config('auth.register_enabled'))
                    <a href="{{ route('register') }}" class="btn btn-outline btn-xl">
                        {{ trans('front.master.call_to_action') }}
                    </a>@endif
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div class="youtube-placeholder" data-yt-url="https://www.youtube.com/embed/TUAMJf22XeM">
                    <img src="https://kanka-app-assets.s3.amazonaws.com/images/front/play-youtube.jpg" async loading="lazy" class="play-youtube-video" alt="Youtube video" title="What is Kanka?" >
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</header>
