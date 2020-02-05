<?php
/**
 * @var \App\Models\CommunityVote $model
 */
?>
<div class="card mb-3 @if($voting) voting @endif">
    <div class="card-body">
        <a href="{{ route('community-votes.show', $model->getSlug()) }}">
            <span class="card-subtitle text-muted">{{ $model->visible_at->isoFormat('MMMM D, Y') }}</span>
            <h3 class="card-title">
                {{ $model->name }}
            </h3>
        </a>
        <div class="card-text">
            {!! nl2br($model->excerpt) !!}
        </div>

        <div  class="mt-2">
            <a href="{{ route('community-votes.show', $model) }}">
            @if ($voting)
                {{ __('front/community-votes.actions.vote') }}
            @else
                {{ __('front/community-votes.actions.show') }}
            @endif
            </a>
        </div>
    </div>
</div>
