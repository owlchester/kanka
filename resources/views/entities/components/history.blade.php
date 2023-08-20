<div class="sidebar-section-box entity-history mb-5 overflow-hidden">
    <div class="sidebar-section-title cursor-pointer text-lg user-select border-b" data-toggle="collapse" data-target="#sidebar-history">
        <i class="fa-solid fa-chevron-right" aria-hidden="true" style="display: none"></i>
        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>

        {{ __('entities/profile.history') }}
    </div>
    <div class="sidebar-elements grid collapse !visible in" id="sidebar-history">
        @if ($model->entity)
            <p class="mt-1">
            {!! __('crud.history.created_clean', [
                'name' => (!empty($model->entity->created_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->entity->created_by)), $model->entity->created_by, ['target' => '_blank']) : __('crud.history.unknown')),
                'date' => '<span data-toggle="tooltip" data-title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
            ]) !!}
            </p>
            <p>{!! __('crud.history.updated_clean', [
            'name' => (!empty($model->entity->updated_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->entity->updated_by)), $model->entity->updated_by, ['target' => '_blank']) : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" data-title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
            </p>
            @can('update', $model)
                <a href="{{ route('entities.logs', [$campaign, $model->entity]) }}" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.logs', [$campaign, $model->entity]) }}" title="{{ __('crud.history.view') }}" class="print-none">
                    <x-icon class="fa-solid fa-history" />
                    <span class="hidden-xs hidden-sm">{{ __('crud.history.view') }}</span>
                </a>
            @endcan
        @else
            <p class="mt-1">
            {!! __('crud.history.created_clean', [
                'name' => (!empty($model->created_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->created_by)), $model->created_by, ['target' => '_blank']) : __('crud.history.unknown')),
                'date' => '<span data-toggle="tooltip" data-title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
            ]) !!}
            </p>
            <p>{!! __('crud.history.updated_clean', [
            'name' => (!empty($model->updated_by) ? link_to_route('users.profile', e(\App\Facades\UserCache::name($model->updated_by)), $model->updated_by, ['target' => '_blank']) : __('crud.history.unknown')),
            'date' =>'<span data-toggle="tooltip" data-title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
            </p>
        @endif
    </div>
</div>
