<div class="entity-modification-history">
    <p class="help-block text-right">
        @if ($model->entity)
        {!! trans('crud.history.created', [
        'name' => ($model->entity->creator ? e($model->entity->creator->name) : trans('crud.history.unknown')),
        'date' => $model->created_at->diffForHumans(),
        'realdate' => $model->created_at . 'UTC',
    ]) !!}. {!! trans('crud.history.updated', [
        'name' => ($model->entity->updater ? e($model->entity->updater->name) : trans('crud.history.unknown')),
        'date' => $model->updated_at->diffForHumans(),
        'realdate' => $model->updated_at . 'UTC',
    ]) !!}
    @else
        {!! trans('crud.history.created', [
        'name' => ($model->creator ? e($model->creator->name) : trans('crud.history.unknown')),
        'date' => $model->created_at->diffForHumans(),
        'realdate' => $model->created_at . 'UTC',
    ]) !!}. {!! trans('crud.history.updated', [
        'name' => ($model->updater ? e($model->updater->name) : trans('crud.history.unknown')),
        'date' => $model->updated_at->diffForHumans(),
        'realdate' => $model->updated_at . 'UTC',
    ]) !!}
    @endif
    </p>
</div>