<?php
/**
 * @var \App\Models\CommunityEvent $model
 */
?>
<div class="card mb-3 @if($ongoing) voting @endif">
    @if (!empty($model->image))
        <img class="card-img-top" src="{{ $model->getImageUrl(1200, 280) }}" alt="{{ $model->name }}">
    @endif
    <div class="card-body">
        <a href="{{ route('community-events.show', $model) }}">
            <h3 class="card-title mb-1">
                {{ $model->name }}
            </h3>
        </a>
        <div class="card-subtitle text-muted mb-2">{{ $model->start_at->isoFormat('MMMM D, Y') }} - {{ $model->end_at->isoFormat('MMMM D, Y') }}</div>
        <div class="card-text">
            {!! nl2br($model->excerpt) !!}
        </div>

        <div class="mt-2">
            <a href="{{ route('community-events.show', $model) }}" class="btn btn-primary">
                {{ __('front/community-events.actions.show_' . ($ongoing ? 'ongoing' : 'past')) }}
            </a>
        </div>
    </div>
</div>
