<?php /**
 * @var \App\Models\Ability $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->ability)
    <div class="entity-header-sub pull-left">
        @if($model->ability)
        <span class="margin-r-5">
        <i class="ra ra-fire-symbol" title="{{ __('abilities.fields.ability') }}" data-toggle="tooltip" ></i>
        {!! $model->ability->tooltipedLink() !!}
        </span>
        @endif
    </div>
@endif
