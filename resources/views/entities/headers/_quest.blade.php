<?php /**
 * @var \App\Models\Quest $model
 */
?>
@if ($model->quest)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon :class="config('entities.icons.quest')" :title="__('crud.fields.parent')"></x-icon>
            {!! $model->quest->tooltipedLink() !!}
        </span>
    </div>
@endif
