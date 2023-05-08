<?php /**
 * @var \App\Models\Quest $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->quest)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon class="ra ra-wooden-sign" :title="__('crud.fields.parent')"></x-icon>
            {!! $model->quest->tooltipedLink() !!}
        </span>
    </div>
@endif
