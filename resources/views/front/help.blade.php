@extends('layouts.front', [
    'menus' => [
        'help',
    ],
    'menu_js' => false,
])
@section('content')

    <section class="features" id="help">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ trans('front.help.title') }}</h2>
                <p class="text-muted">{{ trans('front.help.description') }}</p>

                <div class="row">
                    <div class="col-lg-4 my-auto">
                        <div class="feature-item">
                            <i class="fa fa-twitter"></i>
                            <h3>{{ trans('front.help.twitter') }}</h3>
                            <p class="text-muted"><a href="//twitter.com/kankaio">@kankaio</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 my-auto">
                        <div class="feature-item">
                            <i class="fa fa-commenting-o"></i>
                            <h3>{{ trans('front.help.discord') }}</h3>
                            <p class="text-muted"><a href="https://discord.gg/rhsyZJ4">Discord</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 my-auto">
                        <div class="feature-item">
                            <i class="fa fa-envelope-open"></i>
                            <h3>{{ trans('front.help.email') }}</h3>
                            <p class="text-muted"><a href="mailto:hello@kanka.io">hello@kanka.io</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection