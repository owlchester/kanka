<div class="entity-modification-history">
    <p class="help-block text-right">
        {!! trans('crud.history.created', [
        'name' => ($model->entity->creator ? e($model->entity->creator->name) : trans('crud.history.unknown')),
        'date' => $model->created_at->diffForHumans(),
        'realdate' => $model->created_at . 'UTC',
    ]) !!}. {!! trans('crud.history.updated', [
        'name' => ($model->entity->updater ? e($model->entity->updater->name) : trans('crud.history.unknown')),
        'date' => $model->updated_at->diffForHumans(),
        'realdate' => $model->updated_at . 'UTC',
    ]) !!}</p>
</div>