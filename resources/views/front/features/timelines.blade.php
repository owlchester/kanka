@extends('layouts.front', [
    'title' => __('front/features/timelines.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/timelines.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/timelines.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="features-gm">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="container-fluid text-justify">
                        <p>{{ __('front/features/timelines.first') }}</p>

                        <div style="padding: 70px 0; border: 5px solid black; border-radius: 15px;" class="text-center mb-2">
                            IMAGE
                        </div>

                        <p>{{ __('front/features/timelines.second') }}</p>
                        <p>{{ __('front/features/timelines.third') }}</p>

                        <div style="padding: 70px 0; border: 5px solid black; border-radius: 15px;" class="text-center mb-2">
                            IMAGE
                        </div>


                        <p>{!! __('front/features/timelines.fourth', [
    'boosted_campaigns' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost')
]) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
