@extends('layouts.front', [
    'title' => trans('releases.index.title'),
    'description' => trans('releases.index.description'),
    'menus' => [
        'releases'
    ],
])

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.release.title') }}</h1>
                        <p class="mb-5">{{ trans('front.release.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="releases">
        <div class="container">
            @foreach ($models as $model)
                <h4>
                    <a href="{{ route('releases.show', $model->getSlug()) }}">
                        {{ $model->title }}
                    </a>
                </h4>

                <p class="text-muted">
                    {{ trans('releases.post.footer', ['date' => $model->updated_at->diffForHumans(), 'name' => $model->authorId->name]) }}
                </p>
                <p>
                    {!! $model->excerpt !!}
                </p>
                <hr>
            @endforeach

            {{ $models->appends('order', request()->get('order'))->links() }}
        </div>
    </section>
@endsection