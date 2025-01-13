<?php
if ($model instanceof \App\Models\Post) {
    $modelName = 'Post';
    $modelId = $model->id;
} elseif ($model instanceof \App\Models\Campaign) {
    $modelName = null;
    $modelId = $model->id;
} elseif ($model instanceof \App\Models\TimelineElement) {
    $modelName = 'TimelineElement';
    $modelId = $model->id;
} elseif ($model instanceof \App\Models\QuestElement) {
    $modelName = 'TimelineElement';
    $modelId = $model->id;
} else {
    $modelName = 'Entity';
    $modelId = $model->id;
}
?>
<x-dialog id="edit-warning" :loading="true" :dismissible="false"></x-dialog>
<input type="hidden" name="edit-warning" data-url="{{ route('campaign.editing-warning', [$campaign, 'model' => $modelName, 'id' => $modelId]) }}" />
