<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@can('history', [$model->entity, $campaign])
<div class="entity-modification-history">
    <p class="text-neutral-content text-right italic text-xs m-0">
    @if ($model->entity)
        {!! __('crud.history.created_clean', [
            'name' => (!empty($model->entity->created_by) ? '<a href="' . route('users.profile', $model->entity->created_by) . '">' . e(\App\Facades\UserCache::name($model->entity->created_by)) . '</a>' : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" data-title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
        ]) !!}. {!! __('crud.history.updated_clean', [
            'name' => (!empty($model->entity->updated_by) ? '<a href="' . route('users.profile', $model->entity->updated_by) . '">' . e(\App\Facades\UserCache::name($model->entity->updated_by)) . '</a>' : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" data-title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
        @can('update', $model)
            <br /><a href="{{ route('entities.logs', [$campaign, $model->entity]) }}" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.logs', [$campaign, $model->entity]) }}" title="{{ __('crud.history.view') }}" class="">
                <x-icon class="fa-solid fa-history" />
                <span class="hidden md:inline">{{ __('crud.history.view') }}</span>
            </a>
        @endcan
    @else
        {!! __('crud.history.created_clean', [
            'name' => (!empty($model->created_by) ? '<a href="' . route('users.profile', $model->created_by) . '">' . e(\App\Facades\UserCache::name($model->created_by)) . '</a>': __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" data-title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
        ]) !!}. {!! __('crud.history.updated_clean', [
            'name' => (!empty($model->updated_by) ? '<a href="' . route('users.profile', $model->updated_by) . '">' . e(\App\Facades\UserCache::name($model->updated_by)). '</a>': __('crud.history.unknown')),
            'date' =>'<span data-toggle="tooltip" data-title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
    @endif
    </p>
</div>
@endcan
