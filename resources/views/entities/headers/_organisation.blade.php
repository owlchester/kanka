<?php /**
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->organisation)
    <div class="entity-header-sub pull-left">
        <i class="ra ra-hood" title="{{ __('crud.fields.organisation') }}"></i>

        {!! $model->organisation->tooltipedLink() !!}
    </div>
@endif
