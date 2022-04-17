@extends('layouts.front', [
    'title' => __('front.menu.about'),
    'active' => 'about',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('front.about.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.about') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead" id="about">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front.about.title') }}</h1>
                        <p class="mb-5">{{ __('front.about.description', ['kanka' => config('app.name')]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="team" id="team">
        <div class="container">
            <div class="section-body">
                <h1>{{ __('teams.index.title') }}</h1>

                <div class="row equal text-center">
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="bg-white rounded shadow-sm py-5 px-4 fullheight hover-focus">
                            <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://images.kanka.io/app/rBQO54fZWQxOyJ1yAOrnP0_2qxs=/200x200/smart/src/images%2Fteam%2Fjay.jpg" alt="Jay" width="200">
                            <h5 class="mb-0">Jay</h5>
                            <span class="small text-uppercase text-muted">{{ __('teams.people.jay.title') }}</span>

                            <p class="text-justify mt-1">{!! nl2br(__('teams.people.jay.text')) !!}</p>

                            <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> Jay | Ilestis#9745</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="bg-white rounded shadow-sm py-5 px-4 fullheight hover-focus">
                            <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://images.kanka.io/app/-ZiCBU1NMqqtcZO-Kg3RRxTMGKg=/200x200/smart/src/images%2Fteam%2Fjon.jpg" alt="Jon" width="200">
                            <h5 class="mb-0">Jon</h5>
                            <span class="small text-uppercase text-muted">{{ __('teams.people.jon.title') }}</span>

                            <p class="text-justify mt-1">{!! nl2br(__('teams.people.jon.text')) !!}</p>

                            <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> Karuga#6904</span>
                        </div>K
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="community" class="pt-1 bg-primary">
        <div class="container">
            <div class="section-body">
                <h1>{{ __('teams.index.community') }}</h1>
                <div class="row text-center">
                    <div class="col-xl-3 col-md-4 col-6 mb-4">
                        <div class="bg-white rounded shadow-sm py-5 px-4 fullheight hover-focus">
                            <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://images.kanka.io/app/RFQtdd8vwwFOx_Bcncm2I_l-tBQ=/100x100/smart/src/images%2Fteam%2Fjoseph.jpg" alt="ChaosOS" width="100">
                            <h5 class="mb-0">ChaosOS</h5>
                            <p class="small text-uppercase text-muted">{{ __('teams.people.joseph.title') }}</p>
                            <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> ChaosOS#1948</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-6 mb-4">
                        <div class="bg-white rounded shadow-sm py-5 px-4 fullheight hover-focus">
                            <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://images.kanka.io/app/5NaNz1G4komlYUVsxuqph-Udv3I=/100x100/smart/src/images%2Fteam%2Fryan.jpg" alt="ArcOnyx" width="100">
                            <h5 class="mb-0">ArcOnyx</h5>
                            <p class="small text-uppercase text-muted">{{ __('teams.people.ryan.title') }}</p>
                            <span title="Discord" class="pull-bottom"><i class="fab fa-discord"></i> ArcOnyx#2348</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="translators" id="translators">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 my-auto">
                        <h1>{{ __('teams.index.translations') }}</h1>

                        <p class="text-muted">{!! __('footer.translator_call', ['discord' => link_to(config('discord.url'), 'Discord', ['target' => '_blank'])]) !!}</p>

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
                            <strong>{{ __('languages.codes.pt-BR') }}</strong>: Mire, JP, Republik, Elminster Aumar
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.hr') }}</strong>: Blaze
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.gl') }}</strong>: Daenvil
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.ru') }}</strong>: Ilia
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.sk') }}</strong>: Babcom
                        </p>
                        {{--<p>
                            <strong>{{ __('languages.codes.el') }}</strong>: Charalampos Koundourakis
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.tr') }}</strong>: Lxran
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.gl') }}</strong>: Daenvil
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.nb') }}</strong>: bigboi
                        </p>--}}
                        <p>
                            <strong>{{ __('languages.codes.pl') }}</strong>: <a href="{{ route('front.partners') }}">Gramel Books</a>
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.nl') }}</strong>: ThatChickenGuy
                        </p>

                        <p>
                            <strong>{{ __('languages.codes.fr') }}</strong>: Ilestis
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
