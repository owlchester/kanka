@extends('layouts.app', [
    'title' => trans('releases.index.title'),
    'description' => trans('releases.index.description'),
    'breadcrumbs' => [
        trans('releases.index.title')
    ]
])

@section('content')
    <div class="row">
        <?php $i = 0; ?>
        @foreach ($models as $model)
            <?php if ($i % 4 == 0) echo "</div><div class=\"row\">" ?>
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

                    {!! $model->excerpt !!}

                    <p class="text-muted">
                        {{ trans('releases.post.footer', ['date' => $model->updated_at, 'name' => $model->authorId->name]) }}
                    </p>
                </div>
            </div>
        </div>
        <?php $i++; ?>
        @endforeach
    </div>

    {{ $models->appends('order', request()->get('order'))->links() }}
@endsection