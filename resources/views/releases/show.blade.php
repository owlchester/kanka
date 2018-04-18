@extends('layouts.front', [
    'title' => trans('releases.show.title', ['name' => $model->title]),
    'description' => '',
    'menus' => [
        'releases'
    ],
    'menu_js' => false,
])

@section('content')
    <section class="features" id="releases">
        <div class="container">
            <h2>{{ $model->title }}</h2>

            <p class="text-muted">
                {{ trans('releases.post.footer', ['date' => $model->updated_at, 'name' => $model->authorId->name]) }}
            </p>

            {!! $model->body !!}
            <p><a href="{{ route('releases.index') }}">{{ trans('releases.show.return') }}</a></p>
        </div>
    </section>
@endsection
