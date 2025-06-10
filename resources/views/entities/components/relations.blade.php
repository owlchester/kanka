<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */
$models = $entity->pinnedRelations;
$previousRelation = null;

if (count($models) === 0) {
    return;
}
?>
@foreach ($models as $relation)
    @if(!empty($previousRelation) && $previousRelation == $relation->relation)
    <div class="pinned-relation relation-repeat" data-relation="{{ $relation->target->name }}" data-target="{{ $relation->target_id }}" data-visibility="{{ $relation->visibility_id }}" data-attitude="{{ $relation->attitude }}">
        <div class="text-right">
            <x-entity-link
                :entity="$relation->target"
                :campaign="$campaign" />
        </div>
    </div>
    @else
    <div class="pinned-relation flex gap-2 flex-wrap" data-target="{{ $relation->target_id }}" data-relation="{{ $relation->target->name }}" data-visibility="{{ $relation->visibility_id }}" data-attitude="{{ $relation->attitude }}">
        <strong class="">
            {{ $relation->relation }}
        </strong>
        <span class="grow text-right">
            <x-entity-link
                :entity="$relation->target"
                :campaign="$campaign" />
        </span>
    </div>
@php $previousRelation = $relation->relation @endphp
    @endif
@endforeach
