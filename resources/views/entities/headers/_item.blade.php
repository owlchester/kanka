<?php /**
 * @var \App\Models\Item $model
 */
?>
@if ($model->item)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('items.fields.item') }}" data-toggle="tooltip">
        <i class="ra ra-gem-pendant"></i>
        {!! $model->item->tooltipedLink() !!}
        </span>
    </div>
@endif

