<?php
if (empty($entities) || count($entities) == 0) {
    return;
}
/** @var \App\Models\Entity $entity */
$entity = $entities[0];
if (empty($entity->child)) {
    return;
}
?>
<div class="entity">
    <span class="pull-right elapsed" title="{{ $entity->child->updated_at }}">
        <i class="far fa-clock"></i> {{ $entity->child->updated_at->diffForHumans() }}
    </span>

    <a class="entity-image" style="background-image: url('{{ $entity->avatar(true) }}');"
       title="{{ $entity->name }}"
       href="{{ $entity->url() }}"></a>

    {!! $entity->tooltipedLink() !!}

    <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
        {!! $entity->child->entry() !!}
    </div>
    <a href="#" class="preview-switch hidden"
       id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
        <i class="fa fa-chevron-down"></i>
    </a>
</div>