<header class="masthead masthead-img">
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
            <div class="col-lg-5 text-center my-auto">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/TUAMJf22XeM" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</header>
