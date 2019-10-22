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
      @can('update', $model)
          <a href="{{ route('entities.logs', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.logs', $model->entity) }}" title="{{ __('crud.history.view') }}">
              <i class="fas fa-history"></i> <span class="hidden-xs hidden-sm">{{ __('crud.history.view') }}</span>
          </a>
      @endcan
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