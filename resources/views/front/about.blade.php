@extends('layouts.front', [
    'menus' => [
        'about',
    ],
    'menu_js' => false,
])
@section('content')

    <section class="features" id="about">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ trans('front.about.title') }}</h2>
                <p class="text-muted">{{ trans('front.about.description') }}</p>
            </div>
        </div>
    </section>
@endsection