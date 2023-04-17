@if ($model instanceof \App\Models\Entity)
    @if ($model->is_private)
        <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
    @endif
    {!! $model->tooltipedLink() !!}
    <?php return ?>
@endif

@if ($model instanceof \App\Models\EntityMention)
    @if ($model->isEntity() && $model->entity->is_private || $model->isQuestElement() && $model->questElement->quest->entity->is_private || $model->isTimelineElement() && $model->timelineElement->timeline->entity->is_private || $model->isPost() && $model->post->entity->is_private)
        <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
    @endif
    {!! $model->mentionLink() !!}
    <?php return ?>
@endif

@if ($model->entity->is_private)
    <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
@endif
{!! $model->entity->tooltipedLink() !!}
