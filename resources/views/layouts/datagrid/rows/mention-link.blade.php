@php
    /** @var \App\Models\EntityMention $model */
@endphp
@if ($model->entity_id && !$model->entity)
    {{ __('crud.hidden') }}
    @php return @endphp
@endif
@if ($model->entity)
    @if ($model->entity->is_private)
        <x-icon class="lock" tooltip />
    @endif
    <x-entity-link :entity="$model->entity" :campaign="$campaign" />
@endif

@if ($model->isQuestElement())
    @if ($model->questElement && $model->entity)
        - @include('icons.visibility', ['icon' => $model->questElement->skipAllIcon()->visibilityIcon()])
        <a href="{{ $model->getLink() }}" class="text-link">{!! $model->questElement->name() !!}</a>
    @endif
@elseif ($model->isTimelineElement())
    @if ($model->timelineElement && $model->entity)
        - @include('icons.visibility', ['icon' => $model->timelineElement->skipAllIcon()->visibilityIcon()])
        <a href="{{ $model->getLink() }}" class="text-link">{!! $model->timelineElement->elementName() !!}</a>
    @endif
@elseif ($model->isPost())
    @if ($model->post && $model->entity)
        - @include('icons.visibility', ['icon' => $model->post->skipAllIcon()->visibilityIcon()])
        <a href="{{ $model->getLink() }}" class="text-link">{!! $model->post->name !!}</a>
    @endif
@elseif ($model->isCampaign())
    <a href="{{ route('overview', $campaign) }}" class="text-link">{!! $campaign->name !!}</a>
@endif
