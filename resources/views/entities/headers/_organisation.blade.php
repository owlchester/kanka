<?php /**
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->organisation)
    <div class="entity-header-sub pull-left">
        <i class="ra ra-hood" aria-hidden="true" title="{{ __('crud.fields.parent') }}"></i>

        {!! $model->organisation->tooltipedLink() !!}
    </div>
@endif
