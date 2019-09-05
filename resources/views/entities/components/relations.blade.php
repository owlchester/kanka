<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Relation $relation
 */
$models = $model->entity->starredRelations;
?>
@if (count($models) > 0)
    @foreach ($models as $relation)
        <li class="list-group-item">
            <strong>
                {{ $relation->relation }}
            </strong>
            <span class="pull-right">
                {!! $relation->target->tooltipedLink() !!}
            </span>
            <br class="clear" />
        </li>
    @endforeach
@endif