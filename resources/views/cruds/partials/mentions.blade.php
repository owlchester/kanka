<?php /** @var \App\Models\MiscModel $model */
$mentionCount = $model->entity->targetMentions()->count();
?>
@if ($mentionCount > 0)
    <hr />
    <p class="help-block">
    <a href="{{ route('entities.mentions', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal"
       data-url="{{ route('entities.mentions', $model->entity) }}" title="{{ __('entities/mentions.mentioned_in', ['count' => $mentionCount]) }}">
        {{ __('entities/mentions.mentioned_in', ['count' => $mentionCount]) }}
    </a></p>
@endif
