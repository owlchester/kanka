<header class="masthead masthead-img @nowebp webpfallback @endnowebp">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 my-auto landing-heading">
                <h1 class="">{{ trans('front.master.heading') }}</h1>
            </div>
            <div class="col-lg-7">
                <div class="header-content">
                    <p class="mb-5">{{ trans('front.master.description') }}</p>

                    <a href="{{ route('register') }}" class="btn btn-outline btn-xl">
                        {{ trans('front.master.call_to_action') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="" data-src="https://www.youtube.com/embed/TUAMJf22XeM" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</header>
