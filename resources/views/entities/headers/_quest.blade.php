<?php /**
 * @var \App\Models\Quest $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->quest)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('quests.fields.quest') }}" data-toggle="tooltip">
        <i class="ra ra-wooden-sign"></i>
        {!! $model->quest->tooltipedLink() !!}
        </span>
    </div>
@endif
