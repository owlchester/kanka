<?php /**
 * @var \App\Models\Item $model
 */
?>
@if ($model->item)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon :class="config('entities.icons.item')" :title="__('crud.fields.parent')"></x-icon>
        {!! $model->item->tooltipedLink() !!}
        </span>
    </div>
@endif

