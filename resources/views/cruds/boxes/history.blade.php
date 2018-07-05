<div class="entity-modification-history">
    <p class="help-block text-right">
        {!! trans('crud.history.created', [
        'name' => ($model->entity->creator ? $model->entity->creator->name : trans('crud.history.unknown')),
        'date' => $model->elapsed('created_at'),
        'realdate' => $model->created_at . 'UTC',
    ]) !!}. {!! trans('crud.history.updated', [
        'name' => ($model->entity->updater ? $model->entity->updater->name : trans('crud.history.unknown')),
        'date' => $model->elapsed('updated_at'),
        'realdate' => $model->updated_at . 'UTC',
    ]) !!}</p>
</div>