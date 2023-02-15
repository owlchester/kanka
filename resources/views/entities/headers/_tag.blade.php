<?php /**
 * @var \App\Models\Tag $model
 */
?>
@if ($model->tag)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('tags.fields.tag') }}" data-toggle="tooltip">
        <i class="fa-solid fa-tag"></i>
        {!! $model->tag->tooltipedLink() !!}
        </span>
    </div>
@endif
