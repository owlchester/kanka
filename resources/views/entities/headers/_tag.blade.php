<?php /**
 * @var \App\Models\Tag $model
 */
?>
@if ($model->tag)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
        <i class="fa-solid fa-tag" aria-hidden="true"></i>
        {!! $model->tag->tooltipedLink() !!}
        </span>
    </div>
@endif
