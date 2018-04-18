@extends('layouts.front', [
    'title' => trans('front.menu.about'),
    'menus' => [
        'about',
    ],
    'menu_js' => false,
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
@endsection