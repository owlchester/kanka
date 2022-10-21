<?php /**
 * @var \App\Models\Creature $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->creature)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('creatures.fields.creature') }}" data-toggle="tooltip">
        <i class="ra ra-raven"></i>
        {!! $model->creature->tooltipedLink() !!}
        </span>
    </div>
@endif
