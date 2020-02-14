<?php /** @var \App\Models\Release $model */?>
<div class="card mb-4">
    @if (!empty($model->image))
        <img class="card-img-top" src="{{ Voyager::image($model->image) }}" alt="{{ $model->title }}">
    @endif
    <div class="card-body">
        <h3 class="card-title">
            <a href="{{ route('front.news.show', $model->getSlug()) }}">{{ $model->title }}</a>
        </h3>
        <div class="text-muted mb-2">{{ $model->updated_at->isoFormat('MMMM D, Y') }}</div>

        @if (!empty($preview))
            <p class="card-text">{!! nl2br($model->excerpt) !!}</p>
            <a href="{{ route('front.news.show', $model->getSlug()) }}" class="btn btn-primary">{{ __('front/news.actions.read') }}</a>
        @else
            <div class="card-text">
                {!! $model->body !!}
            </div>
        @endif
    </div>
</div>
