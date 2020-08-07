@can('history', [$model->entity, $campaign->campaign()])
<div class="entity-modification-history">
    <p class="help-block text-right">
    @if ($model->entity)
        {!! __('crud.history.created', [
            'name' => (!empty($model->entity->created_by) ? e(\App\Facades\UserCache::name($model->entity->created_by)) : __('crud.history.unknown')),
            'date' => $model->created_at->diffForHumans(),
            'realdate' => $model->created_at . 'UTC',
        ]) !!}. {!! __('crud.history.updated', [
            'name' => (!empty($model->entity->updated_by) ? e(\App\Facades\UserCache::name($model->entity->updated_by)) : __('crud.history.unknown')),
            'date' => $model->updated_at->diffForHumans(),
            'realdate' => $model->updated_at . 'UTC',
        ]) !!}
      @can('update', $model)
          <br /><a href="{{ route('entities.logs', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.logs', $model->entity) }}" title="{{ __('crud.history.view') }}">
              <i class="fas fa-history"></i> <span class="hidden-xs hidden-sm">{{ __('crud.history.view') }}</span>
          </a>
      @endcan
    @else
        {!! __('crud.history.created', [
            'name' => (!empty($model->created_by) ? e(\App\Facades\UserCache::name($model->created_by)) : __('crud.history.unknown')),
            'date' => $model->created_at->diffForHumans(),
            'realdate' => $model->created_at . ' UTC',
        ]) !!}. {!! __('crud.history.updated', [
            'name' => (!empty($model->updated_by) ? e(\App\Facades\UserCache::name($model->updated_by)) : __('crud.history.unknown')),
            'date' => $model->updated_at->diffForHumans(),
            'realdate' => $model->updated_at . ' UTC',
        ]) !!}
    @endif
    </p>
</div>
@endcan
