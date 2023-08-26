<?php /**
 * @var \App\Models\Race $model
 */
?>
@if ($model->race)
    <div class="entity-header-sub pull-left">
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon :class="config('entities.icons.race')" :title="__('crud.fields.parent')"></x-icon>
            {!! $model->race->tooltipedLink() !!}
        </span>
    </div>
@endif
