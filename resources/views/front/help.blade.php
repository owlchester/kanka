@extends('layouts.front', [
    'title' => trans('front.menu.help'),
    'menus' => [
        'help',
    ],
    'menu_js' => false,
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.help.title') }}</h1>
                        <p class="mb-5">{{ trans('front.help.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="help">
        <div class="container">
            <div class="section-heading text-center">

                <div class="row">
                    <div class="col-lg-4 my-auto">
                        <div class="feature-item">
                            <i class="fab fa-twitter"></i>
                            <h3>{{ trans('front.help.twitter') }}</h3>
                            <p class="text-muted"><a href="//twitter.com/kankaio">@kankaio</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 my-auto">
                        <div class="feature-item">
                            <i class="fab fa-discord"></i>
                            <h3>{{ trans('front.help.discord') }}</h3>
                            <p class="text-muted"><a href="{{ config('discord.url') }}">Discord</a></p>
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