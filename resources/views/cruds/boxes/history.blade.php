<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@can('history', [$model->entity, $campaign->campaign()])
<div class="entity-modification-history">
    <p class="help-block text-right">
    @if ($model->entity)
        {!! __('crud.history.created_clean', [
            'name' => (!empty($model->entity->created_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->entity->created_by)), $model->entity->created_by, ['target' => '_blank']) : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
        ]) !!}. {!! __('crud.history.updated_clean', [
            'name' => (!empty($model->entity->updated_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->entity->updated_by)), $model->entity->updated_by, ['target' => '_blank']) : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
      @can('update', $model)
          <br /><a href="{{ route('entities.logs', $model->entity) }}" data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route('entities.logs', $model->entity) }}" title="{{ __('crud.history.view') }}" class="">
              <i class="fas fa-history"></i> <span class="hidden-xs hidden-sm">{{ __('crud.history.view') }}</span>
          </a>
      @endcan
    @else
        {!! __('crud.history.created_clean', [
            'name' => (!empty($model->created_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->created_by)), $model->created_by, ['target' => '_blank']) : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
        ]) !!}. {!! __('crud.history.updated_clean', [
            'name' => (!empty($model->updated_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->updated_by)), $model->updated_by, ['target' => '_blank']) : __('crud.history.unknown')),
            'date' =>'<span data-toggle="tooltip" title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
    @endif
    </p>
</div>
@endcan
