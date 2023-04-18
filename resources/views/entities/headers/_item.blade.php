<?php /**
 * @var \App\Models\Item $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->item)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('items.fields.item') }}" data-toggle="tooltip">
        <i class="ra ra-gem-pendant" aria-hidden="true"></i>
        {!! $model->item->tooltipedLink() !!}
        </span>
    </div>
@endif

