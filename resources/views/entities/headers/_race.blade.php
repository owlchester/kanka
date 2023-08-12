<?php /**
 * @var \App\Models\Race $model
 */
?>
@if ($model->race)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon class="ra ra-wyvern" :title="__('crud.fields.parent')"></x-icon>
            {!! $model->race->tooltipedLink() !!}
        </span>
    </div>
@endif
