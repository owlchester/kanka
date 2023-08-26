<?php /**
 * @var \App\Models\Creature $model
 */
?>
@if ($model->creature)
    <div class="entity-header-sub pull-left">
        <x-icon entity="creature" :title="__('crud.fields.parent')"/>
        {!! $model->creature->tooltipedLink() !!}
    </div>
@endif
