<?php /**
 * @var \App\Models\Item $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->item)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon class="ra ra-gem-pendant" :title="__('crud.fields.parent')"></x-icon>
        {!! $model->item->tooltipedLink() !!}
        </span>
    </div>
@endif

