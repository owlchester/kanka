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
                <a href="{{ $relation->target->url() }}" title="{{ $relation->target->tooltipWithName() }}" data-toggle="tooltip" data-html="true">
                    {{ $relation->target->name }}
                </a>
            </strong>
            <span class="pull-right">{{ $relation->relation }}</span>
            <br class="clear" />
        </li>
    @endforeach
@endif