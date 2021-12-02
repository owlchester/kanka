<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Relation $relation
 */
$models = isset($entity) ? $entity->starredRelations : $model->entity->starredRelations;
$previousRelation = null;

if (count($models) === 0) {
    return;
}
?>
@foreach ($models as $relation)
    @if(!empty($previousRelation) && $previousRelation == $relation->relation)
    <li class="list-group-item list-group-item-repeat pinned-relation" data-relation="{{ $relation->target->name }}" data-target="{{ $relation->target_id }}" data-visibility="{{ $relation->visibility }}">
        <span class="pull-right">
            {!! $relation->target->tooltipedLink() !!}
        </span>
        <br class="clear" />
    </li>
    @else
    <li class="list-group-item pinned-relation" data-target="{{ $relation->target_id }}" data-relation="{{ $relation->target->name }}" data-visibility="{{ $relation->visibility }}">
        <strong>
            {{ $relation->relation }}
        </strong>
        <span class="pull-right">
            {!! $relation->target->tooltipedLink() !!}
        </span>
        <br class="clear" />
@php $previousRelation = $relation->relation @endphp
    @endif
@endforeach
