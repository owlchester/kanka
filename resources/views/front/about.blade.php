@extends('layouts.front', [
    'title' => __('front.menu.about'),
    'active' => 'about'
])

@section('og')
    <meta property="og:description" content="{{ __('front.about.description') }}" />
    <meta property="og:url" content="{{ route('front.about') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead" id="about">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front.about.title') }}</h1>
                        <p class="mb-5">{{ __('front.about.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="team" id="team">
        <div class="container">
            <div class="section-body">
                <h1>{{ __('teams.index.title') }}</h1>

                <div class="row">
                    <div class="col-lg-3 col-sm-4 col-12 mb-2">
                        <div class="card">
                            <img class="card-img-top" src="https://kanka-app-assets.s3.amazonaws.com/images/team/jay.jpg" alt="Jay">
                            <div class="card-body">
                                <h5 class="card-title">Jay</h5>
                                <p class="text-muted">{{ __('teams.people.jay.title') }}</p>
                                <p class="card-text">{!! nl2br(__('teams.people.jay.text')) !!}</p>

                                <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> Jay | Ilestis#9745</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4 col-12 mb-2">
                        <div class="card">
                            <img class="card-img-top" src="https://kanka-app-assets.s3.amazonaws.com/images/team/jon.jpg" alt="Jonathan">
                            <div class="card-body">
                                <h5 class="card-title">Jonathan</h5>
                                <p class="text-muted">{{ __('teams.people.jon.title') }}</p>
                                <p class="card-text">{!! nl2br(__('teams.people.jon.text')) !!}</p>

                                <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> Karuga#6904</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4 col-12 mb-2">
                        <div class="card">
                            <img class="card-img-top" src="https://kanka-app-assets.s3.amazonaws.com/images/team/ryan.jpg" alt="Ryan">
                            <div class="card-body">
                                <h5 class="card-title">Ryan</h5>
                                <p class="text-muted">{{ __('teams.people.ryan.title') }}</p>
                                <p class="card-text">{!! nl2br(__('teams.people.ryan.text')) !!}</p>

                                <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> ArcOnyx#2348</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-5">{{ __('teams.index.community') }}</h2>
                <div class="row ">
{{--                    <div class="col-lg-3 col-sm-4 col-6 mb-2">--}}
{{--                        <div class="card">--}}
{{--                            <img class="card-img-top" src="https://kanka-app-assets.s3.amazonaws.com/images/team/iz.jpg" alt="Iz Groceman">--}}
{{--                            <div class="card-body">--}}
{{--                                <h5 class="card-title">Iz Groceman <a href="mailto:dm@timeraverse.com"><i class="fas fa-envelope"></i></a></h5>--}}
{{--                                <p class="text-muted">{{ __('teams.people.iz.title') }}</p>--}}

{{--                                <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> Timera#2707</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-lg-3 col-sm-4 col-6 mb-2">
                        <div class="card">
                            <img class="card-img-top" src="https://kanka-app-assets.s3.amazonaws.com/images/team/joseph.jpg" alt="ChaosOS">
                            <div class="card-body">
                                <h5 class="card-title">ChaosOS</h5>
                                <p class="text-muted">{{ __('teams.people.joseph.title') }}</p>

                                <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> ChaosOS#1948</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="translators bg-primary " id="translators">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 my-auto">
                        <h2>{{ __('teams.index.translations') }}</h2>
                        <p>
                            <strong>{{ __('languages.codes.de') }}</strong>: TheFurya, Yanila, Thogrim, Xoltax
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.es') }}</strong>: Helionking, Raigho
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.ca') }}</strong>: Helionking
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.it') }}</strong>: Dreadino, Arroagantes, VolpeNera
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.hu') }}</strong>: Kildar, Orkogo, orwen89
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.pt-BR') }}</strong>: Republik
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.hr') }}</strong>: Blaze
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.he') }}</strong>: Beefpotato
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.ru') }}</strong>: Ilia
                        </p>
{{--                        <p>--}}
{{--                            <strong>{{ __('languages.codes.sk') }}</strong>: Babcom--}}
{{--                        </p>--}}
{{--                        <p>--}}
{{--                            <strong>{{ __('languages.codes.el') }}</strong>: Charalampos Koundourakis--}}
{{--                        </p>--}}
                        <p>
                            <strong>{{ __('languages.codes.fr') }}</strong>: Ilestis
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="patreons" id="patreon">
        <div class="container">
            <div class="section-body">
                <h1>{{ __('teams.hall_of_fame') }}</h1>
                <p class="text-muted">{{ __('teams.patreon.description') }}
                    <a href="{{ route('front.features', ['#paid-features']) }}">{{ __('teams.patreon.learn_more') }}</a>.
                </p>

                <div class="card">
                    <div class="card-body">
                        <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png);"></div>
                        <h5 class="card-title text-muted text-uppercase text-center">Elemental</h5>

                        <div class="row text-center">
                        @foreach (\Illuminate\Support\Arr::get($patrons, 'Elemental', []) as $user)
                            <div class="col-md-4 col-6">{{ $user->name }}</div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png);"></div>
                        <h5 class="card-title text-muted text-uppercase text-center">Owlbear</h5>

                        <div class="row text-center">
                            @foreach (\Illuminate\Support\Arr::get($patrons, 'Owlbear', []) as $user)
                                <div class="col-md-4 col-6 ">{{ $user->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/goblin-325.png);"></div>
                        <h5 class="card-title text-muted text-uppercase text-center">Goblin</h5>

                        <div class="row text-center">
                            @foreach (\Illuminate\Support\Arr::get($patrons, 'Goblin', []) as $user)
                                <div class="col-md-4 col-6">{{ $user->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
