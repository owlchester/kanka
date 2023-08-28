<?php /**
 * @var \App\Models\Quest $model
 */
?>
@if ($model->quest)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon entity="quest" :title="__('crud.fields.parent')"/>
            {!! $model->quest->tooltipedLink() !!}
        </span>
    </div>
@endif
