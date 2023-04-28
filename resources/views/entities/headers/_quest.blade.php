<?php /**
 * @var \App\Models\Quest $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->quest)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
        <i class="ra ra-wooden-sign" aria-hidden="true"></i>
        {!! $model->quest->tooltipedLink() !!}
        </span>
    </div>
@endif
