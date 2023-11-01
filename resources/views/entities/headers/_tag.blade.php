<?php /**
 * @var \App\Models\Tag $model
 */
?>
@if ($model->tag)
    <div class="entity-header-sub pull-left">
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
        <x-icon class="fa-solid fa-tag" />
        {!! $model->tag->tooltipedLink() !!}
        </span>
    </div>
@endif
