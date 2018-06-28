<div class="entity-modification-history">
    <p class="help-block text-right">
        {!! trans('crud.history.created', [
        'name' => ($model->entity->creator ? $model->entity->creator->name : trans('crud.history.unknown')),
        'date' => $model->entity->elapsed('created_at'),
        'realdate' => $model->entity->created_at . 'UTC',
    ]) !!}. {!! trans('crud.history.updated', [
        'name' => ($model->entity->updater ? $model->entity->updater->name : trans('crud.history.unknown')),
        'date' => $model->entity->elapsed('updated_at'),
        'realdate' => $model->entity->updated_at . 'UTC',
    ]) !!}</p>
</div>