@extends('layouts.front', [
    'title' => trans('faq.show.title', ['name' => $model->question]),
    'description' => '',
    'menus' => [
        'faq'
    ],
    'menu_js' => false,
])

@section('content')
    <section class="features" id="faqs">
        <div class="container">
            <h2>{{ e($model->question) }}</h2>

            <p class="text-muted">
                {{ trans('faq.show.timestamp', ['date' => $model->updated_at->diffForHumans()]) }}
            </p>

            <p>{!! $model->answer !!}</p>


            <p><a href="{{ route('faq.index') }}">{{ trans('faq.show.return') }}</a></p>
        </div>
    </section>
@endsection
