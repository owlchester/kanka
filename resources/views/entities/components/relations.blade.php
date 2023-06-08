<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Relation $relation
 */
$models = isset($entity) ? $entity->pinnedRelations : $model->entity->pinnedRelations;
$previousRelation = null;

if (count($models) === 0) {
    return;
}
?>
@foreach ($models as $relation)
    @if(!empty($previousRelation) && $previousRelation == $relation->relation)
    <li class="mb-2 pinned-relation" data-relation="{{ $relation->target->name }}" data-target="{{ $relation->target_id }}" data-visibility="{{ $relation->visibility_id }}">
        <span class="pull-right">
            {!! $relation->target->tooltipedLink() !!}
        </span>
        <br class="clear-both" />
    </li>
    @else
    <li class="mb-2 pinned-relation" data-target="{{ $relation->target_id }}" data-relation="{{ $relation->target->name }}" data-visibility="{{ $relation->visibility }}">
        <strong>
            {{ $relation->relation }}
        </strong>
        <span class="pull-right">
            {!! $relation->target->tooltipedLink() !!}
        </span>
        <br class="clear-both" />
    </li>
@php $previousRelation = $relation->relation @endphp
    @endif
@endforeach
