<?php /**
 * @var \App\Models\Race $model
 */
?>
@if ($model->race)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('races.fields.race') }}" data-toggle="tooltip">
        <i class="ra ra-wyvern"></i>
        {!! $model->race->tooltipedLink() !!}
        </span>
    </div>
@endif
