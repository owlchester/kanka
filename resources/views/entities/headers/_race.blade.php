<?php /**
 * @var \App\Models\Race $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->race)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
        <i class="ra ra-wyvern" aria-hidden="true"></i>
        {!! $model->race->tooltipedLink() !!}
        </span>
    </div>
@endif
