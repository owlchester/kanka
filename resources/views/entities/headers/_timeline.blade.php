<?php /**
 * @var \App\Models\Timeline $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->timeline)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('timelines.fields.timeline') }}" data-toggle="tooltip">
        <i class="fa-solid fa-hourglass-half"></i>
        {!! $model->timeline->tooltipedLink() !!}
        </span>
    </div>
@endif
