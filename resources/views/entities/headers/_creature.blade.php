<?php /**
 * @var \App\Models\Creature $model
 */
?>
@if ($model->creature)
    <div class="entity-header-sub pull-left">
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon class="ra ra-raven"></x-icon>
        {!! $model->creature->tooltipedLink() !!}
        </span>
    </div>
@endif
