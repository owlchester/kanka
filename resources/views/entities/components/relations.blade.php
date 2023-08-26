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
    <div class="pinned-relation relation-repeat" data-relation="{{ $relation->target->name }}" data-target="{{ $relation->target_id }}" data-visibility="{{ $relation->visibility_id }}">
        <div class="text-right">
            {!! $relation->target->tooltipedLink() !!}
        </div>
    </div>
    @else
    <div class="pinned-relation flex gap-2" data-target="{{ $relation->target_id }}" data-relation="{{ $relation->target->name }}" data-visibility="{{ $relation->visibility_id }}">
        <strong class="flex-none">
            {{ $relation->relation }}
        </strong>
        <span class="grow text-right">
            {!! $relation->target->tooltipedLink() !!}
        </span>
    </div>
@php $previousRelation = $relation->relation @endphp
    @endif
@endforeach
