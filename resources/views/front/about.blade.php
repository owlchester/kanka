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

    <section class="team" id="team">
        <div class="container">
            <div class="section-body text-center">
                <div class="mb-5">
                    <h1>{{ __('teams.index.lead', ['kanka' => config('app.name')]) }}</h1>
                    <p class="lead">{{ __('teams.leads.about') }}</p>
                </div>

                <h2 class="mb-3">{{ __('teams.index.title') }}</h2>

                <div class="row equal text-center">
                    <div class="col-xl-4 col-md-6 col-12 mb-4 offset-2">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="community" class="pt-1 bg-primary">
        <div class="container">
            <div class="section-body">
                <h2>{{ __('teams.index.community') }}</h2>
                <p class="lead">{{ __('teams.leads.community') }}</p>
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
                <div class="mb-5">
                <h2>{{ __('teams.index.translations') }}</h2>

                <p class="lead">{!! __('teams.leads.translators') !!}</p>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>
                            <strong>{{ __('languages.codes.en') }}, {{ __('languages.codes.fr') }}</strong>: Kanka Team
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.pt-BR') }}</strong>: Mire, JP, Republik, Elminster Aumar
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.de') }}</strong>: TheFurya, Yanila, Thogrim, Xoltax
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.es') }}</strong>: Helionking, Raigho
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.it') }}</strong>: TaoTrooper, VolpeNera, Dreadino, Arroagantes
                        </p>
                    </div>
                    <div class="col-12 col-md-6">

                        <p>
                            <strong>{{ __('languages.codes.ru') }}</strong>: Ilia
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.pl') }}</strong>: <a href="{{ route('front.partners') }}">Gramel Books</a>
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.nl') }}</strong>: ThatChickenGuy
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.ca') }}</strong>: Helionking
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.hu') }}</strong>: Kildar, Orkogo, orwen89
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.sk') }}</strong>: Babcom
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.hr') }}</strong>: Blaze
                        </p>
                        <p>
                            <strong>{{ __('languages.codes.gl') }}</strong>: Daenvil
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
