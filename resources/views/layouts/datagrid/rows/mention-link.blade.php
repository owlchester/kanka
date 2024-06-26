@php
    /** @var \App\Models\EntityMention $model */
@endphp
@if ($model->entity_id && !$model->entity)
    {{ __('crud.hidden') }}
    @php return @endphp
@endif
@if ($model->entity)
    @if ($model->entity->is_private)
        <x-icon class="fa-solid fa-lock" tooltip :title="__('aaa')" />
    @endif
    <x-entity-link :entity="$model->entity" :campaign="$campaign" />
@endif

@if ($model->isQuestElement())
    @if ($model->questElement && $model->entity)
        - {!! $model->questElement->skipAllIcon()->visibilityIcon() !!}
        <a href="{{ $model->getLink() }}">{!! $model->questElement->name() !!}</a>
    @endif
@elseif ($model->isTimelineElement())
    @if ($model->timelineElement && $model->entity)
        - {!! $model->timelineElement->skipAllIcon()->visibilityIcon() !!}
        <a href="{{ $model->getLink() }}">{!! $model->timelineElement->name() !!}</a>
    @endif
@elseif ($model->isPost())
    @if ($model->post && $model->entity)
        - {!! $model->post->skipAllIcon()->visibilityIcon() !!}
        <a href="{{ $model->getLink() }}">{!! $model->post->name !!}</a>
    @endif
@elseif ($model->isCampaign())
    <a href="{{ route('overview', $campaign) }}">{!! $campaign->name !!}</a>
@endif
