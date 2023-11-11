<?php /**
 * @var \App\Models\Tag $model
 */
?>
@if ($model->tag)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon :class="\App\Facades\Module::duoIcon('tag')" :title="__('crud.fields.parent')" />
            {!! $model->tag->tooltipedLink() !!}
        </span>
    </div>
@endif
