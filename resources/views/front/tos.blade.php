@extends('layouts.front', [
    'title' => trans('front.menu.tos'),
    'menus' => [
        'tos',
    ],
])
@section('content')

    <section class="features" id="about">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ trans('front.tos.title') }}</h2>
                <p class="text-muted">{{ trans('front.tos.description') }}</p>
                <hr>
            </div>
        </div>
    </section>
@endsection