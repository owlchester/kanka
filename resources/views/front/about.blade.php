@extends('layouts.front', [
    'title' => trans('front.menu.about'),
    'menus' => [
        'about',
    ],
    'menu_js' => false,
])
@section('content')

    <header class="masthead reduced-masthead" id="about">
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
                                <strong>Lead</strong>: Ilestis <a href="https://ko-fi.com/kankaio" target="_blank" title="{{ trans('front.team.coffee') }}" data-toggle="tooltip"><i class="fa fa-coffee"></i></a>
                            </p>
                    </div>
                    <div class="col-lg-4 my-auto">
                        <h4>{{ trans('teams.index.translations') }}</h4>
                        <p>
                            <strong>{{ trans('languages.codes.de') }}</strong>: TheFurya
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.en-US') }}</strong>: Oriek
                        </p>
                        <p>
                            <strong>{{ trans('languages.codes.es') }}</strong>: Raigho, Helionking
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
                            <strong>{{ trans('teams.index.qa') }}</strong>: ArcOnyx, anna unfairest, RS_Chops
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="patreon">
        <div class="container">
            <div class="section-body">
                <h1>{{ trans('teams.patreon.title') }}</h1>
                <p class="text-muted">{{ trans('teams.patreon.description') }}
                    <a href="https://patreon.com/kankaio" class="" target="_blank">{{ __('footer.patreon') }}</a>
                </p>

                <div class="row">
                    @foreach ($users as $user)
                        <div class="col-md-3 col-sm-4 col-xs-6">{{ $user->patreon_fullname }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection