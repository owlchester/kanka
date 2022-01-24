<?php /** @var \App\Models\MiscModel $model */
$mentionCount = $model->entity->targetMentions()->entity()->has('entity')->entityAcl()->count() +
    $model->entity->targetMentions()->entityNote()->entityNoteAcl()->has('entityNote.entity')->count() +
    $model->entity->targetMentions()->campaign()->count();
?>
@if ($mentionCount > 0)
    <div class="box box-solid entity-mentions-box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('entities/mentions.title') }}</h3>
        </div>
        <div class="box-body">
            {!! __('entities/mentions.mentioned_in_v2', [
    'count' => $mentionCount,
    'more' => link_to_route(
        'entities.mentions',
        __('entities/mentions.see_more'),
        $model->entity,
        [
            'data-toggle' => 'ajax-modal',
            'data-url' => route('entities.mentions', $model->entity),
            'data-target' => '#entity-modal',
        ]
    )
]) !!}
        </div>
    </div>
@endif
