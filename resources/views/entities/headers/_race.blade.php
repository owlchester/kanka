<?php /**
 * @var \App\Models\Race $model
 */
?>
@if ($model->race)
    <div class="entity-header-sub pull-left">
            <x-icon entity="race" :title="__('crud.fields.parent')"/>
            {!! $model->race->tooltipedLink() !!}
        </span>
    </div>
@endif
