<?php /**
 * @var \App\Models\Item $model
 */
?>
@if ($model->item)
    <div class="entity-header-sub pull-left">
        <x-icon entity="item" :title="__('crud.fields.parent')"/>
        {!! $model->item->tooltipedLink() !!}
    </div>
@endif

