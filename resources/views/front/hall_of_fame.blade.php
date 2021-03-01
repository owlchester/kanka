@extends('layouts.front', [
    'title' => __('front/hall-of-fame.title'),
    'active' => 'hall-of-fame',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('front/hall-of-fame.description') }}" />
    <meta property="og:url" content="{{ route('front.hall-of-fame') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead" id="hall-of-fame">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/hall-of-fame.title') }}</h1>
                        <p class="mb-5">{!! __('front/hall-of-fame.description', [
    'features' => link_to_route('front.features', __('front.menu.features'), ['#paid-features'])
]) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="subscribers" id="subscribers">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png);"></div>
                                <h5 class="card-title text-muted text-uppercase text-center">Elemental</h5>

                                <div class="row text-center">
                                @foreach (\Illuminate\Support\Arr::get($patrons, 'Elemental', []) as $user)
                                    <div class="col-lg-3 col-md-4 col-6">{{ $user }}</div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/wyvern-325.png);"></div>
                                <h5 class="card-title text-muted text-uppercase text-center">Wyvern</h5>

                                <div class="row text-center">
                                @foreach (\Illuminate\Support\Arr::get($patrons, 'Wyvern', []) as $user)
                                    <div class="col-lg-3 col-md-4 col-6">{{ $user }}</div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png);"></div>
                                <h5 class="card-title text-muted text-uppercase text-center">Owlbear</h5>

                                <div class="row text-center">
                                    @foreach (\Illuminate\Support\Arr::get($patrons, 'Owlbear', []) as $user)
                                        <div class="col-lg-3 col-md-4 col-6 ">{{ $user }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/goblin-325.png);"></div>
                                <h5 class="card-title text-muted text-uppercase text-center">Goblin</h5>

                                <div class="row text-center">
                                    @foreach (\Illuminate\Support\Arr::get($patrons, 'Goblin', []) as $user)
                                        <div class="col-lg-3 col-md-4 col-6">{{ $user }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
