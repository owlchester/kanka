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
                <a href="{{ $relation->target->url() }}" title="{{ $relation->target->tooltipWithName() }}" data-toggle="tooltip" data-html="true">
                    {{ $relation->target->name }}
                </a>
            </span>
            <br class="clear" />
        </li>
    @endforeach
@endif