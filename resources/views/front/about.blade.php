@extends('layouts.front', [
    'title' => trans('front.menu.about'),
])
@section('content')

    <header class="masthead" id="about">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.about.title') }}</h1>
                        <p class="mb-5">{{ trans('front.about.description') }}</p>

                        <a href="{{ route('register') }}" class="btn btn-outline btn-xl js-scroll-trigger">
                            {{ trans('front.master.call_to_action') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="team">
        <div class="container">
            <div class="section-body">
                <h1>{{ trans('teams.index.title') }}</h1>
                <p class="text-muted">{{ trans('teams.index.description') }}</p>

                <div class="row">
                    <div class="col-lg-4 ">
                        <h4>{{ trans('teams.index.core') }}</h4>

                        <p>
                            <strong>Lead</strong>: <a href="mailto:hello@kanka.io">Ilestis</a>
                            <a href="https://ko-fi.com/kankaio" target="_blank" title="{{ trans('front.team.coffee') }}" data-toggle="tooltip"><i class="fa fa-coffee"></i></a><br />
                            <span title="Discord">@Ilestis#9745</span>
                        </p>
                        <p>
                            <strong>QA Lead</strong>: ArcOnyx<br />
                            <span title="Discord">@ArcOnyx#2348</span>
                        </p>

                        <h4>{{ trans('teams.index.support') }}</h4>

                        <p>
                            <strong>Product Development</strong>: <a href="mailto:dm@timeraverse.com">Iz Groceman</a><br />
                            <span title="Discord">@Timera#2707</span>
                        </p>
                    </div>
                    <div class="col-lg-4 my-auto">
                        <h4>{{ trans('teams.index.translations') }}</h4>
                        <p>
                            <strong>{{ trans('languages.codes.de') }}</strong>: TheFurya, Yanila, Thogrim
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.en-US') }}</strong>: Oriek
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.es') }}</strong>: Helionking, Raigho
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.it') }}</strong>: Dreadino, Arroagantes
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.hu') }}</strong>: Kildar, Orkogo
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.pt-BR') }}</strong>: Republik
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.fr') }}</strong>: Ilestis
                        </p>
                    </div>

                    <div class="col-lg-4">
                        <h4>{{ trans('teams.index.other') }}</h4>
                        <p>
                            <strong>{{ trans('teams.index.qa') }}</strong>: ChaosOS
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="patreon">
        <div class="container">
            <div class="section-body">
                <h1>{{ trans('teams.hall_of_fame') }}</h1>
                <p class="text-muted">{{ trans('teams.patreon.description') }}
                    <a href="{{ config('patreon.url') }}" class="" target="_blank">{{ __('footer.patreon') }}</a>.
                    <a href="{{ route('front.features', ['#patreon']) }}">{{ __('teams.patreon.learn_more') }}</a>.
                </p>

                    @foreach ($patrons as $pledge => $users)
                        @if (!empty($users) && $pledge != \App\Models\Patreon::PLEDGE_KOBOLD)
                            <h4>{{ $pledge }}</h4>
                            <div class="row patreon-pledge">
                            @foreach ($users as $user)
                            <div class="col-md-3 col-sm-4 col-xs-6">{{ $user->patreon_fullname }}</div>
                            @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection