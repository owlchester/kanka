<header class="masthead">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-7 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5">{{ trans('front.master.title') }}</h1>
                    <p class="mb-5">{{ trans('front.master.description') }}</p>

                    <a href="{{ route('register') }}" class="btn btn-outline btn-xl js-scroll-trigger">
                        {{ trans('front.master.call_to_action') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-5 my-auto">
                <div class="device-container">
                    <div class="device-mockup iphone6_plus portrait white">
                        <div class="device">
                            <div class="screen">
                                <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                <img src="/images/front/home-image.png" class="img-fluid" alt="{{ config('app.name') }} dashboard">
                            </div>
                            <div class="button">
                                <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>