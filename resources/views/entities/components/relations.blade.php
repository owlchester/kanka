<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Relation $relation
 */
$models = $model->entity->starredRelations;
$previousRelation = null;
?>
@if (count($models) > 0)
    @foreach ($models as $relation)
        @if(!empty($previousRelation) && $previousRelation == $relation->relation)
        <li class="list-group-item list-group-item-repeat">
            <span class="pull-right">
                {!! $relation->target->tooltipedLink() !!}
            </span>
            <br class="clear" />
        </li>
        @else
        <li class="list-group-item">
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
@endif
