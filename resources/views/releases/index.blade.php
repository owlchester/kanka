@extends('layouts.app', [
    'title' => trans('releases.index.title'),
    'description' => trans('releases.index.description'),
])

@section('content')
    <div class="row">
        @foreach ($models as $model)
        <div class="col-md-3">
            <div class="box news">
                <div class="box-body">
                    @if ($model->image)
                    <img src="/storage/{{ $model->image }}" style="width:100%" />
                    @endif

                    <h2>
                        <a href="{{ route('releases.show', $model->getSlug()) }}">
                            {{ $model->title }}
                        </a>
                    </h2>

                    @if ($model->excerpt)
                    {!! $model->excerpt !!}
                    @else
                    {!! $model->body !!}
                    @endif

                    <p class="text-muted">
                        {{ trans('releases.post.footer', ['date' => $model->updated_at, 'name' => $model->authorId->name]) }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $models->appends('order', request()->get('order'))->links() }}
@endsection
