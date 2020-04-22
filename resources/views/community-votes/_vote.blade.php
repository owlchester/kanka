<?php
/**
 * @var \App\Models\CommunityVote $model
 */
?>
<div class="card mb-3 @if($voting) voting @endif">
    <div class="card-body">
        <a href="{{ route('community-votes.show', $model->getSlug()) }}">
            <h3 class="card-title mb-1">
                {{ $model->name }}
            </h3>
        </a>
        <div class="card-subtitle text-muted mb-2">{{ $model->visible_at->isoFormat('MMMM D, Y') }}</div>
        <div class="card-text">
            {!! nl2br($model->excerpt) !!}
        </div>

        <div  class="mt-2">
            @if ($voting)
            <a href="{{ $model->link }}" class="btn btn-primary">
                {{ __('front/community-votes.actions.vote') }}
            </a>
            @else
            <a href="{{ $model->link }}">
                {{ __('front/community-votes.actions.show') }}
            </a>
            @endif
        </div>
    </div>
</div>
