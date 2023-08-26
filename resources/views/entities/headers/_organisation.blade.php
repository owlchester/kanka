<?php /**
 * @var \App\Models\Map $model
 */
?>
@if ($model->organisation)
    <div class="entity-header-sub pull-left">
        <x-icon :class="config('entities.icons.organisation')" :title="__('crud.fields.parent')"></x-icon>

        {!! $model->organisation->tooltipedLink() !!}
    </div>
@endif
