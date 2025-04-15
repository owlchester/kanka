<div class="sidebar-section-box entity-history overflow-hidden flex flex-col gap-2">
    <div class="sidebar-section-title cursor-pointer user-select border-b element-toggle group" data-animate="collapse" data-target="#sidebar-history">
        <x-icon class="fa-solid fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
        <x-icon class="fa-solid fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
        <span class="text-lg">{{ __('entities/profile.history') }}</span>
    </div>
    <div class="sidebar-elements overflow-hidden" id="sidebar-history">
        <div class="flex flex-col gap-2 text-xs">
        @if ($entity)
            <p class="m-0">
            {!! __('crud.history.created_clean', [
                'name' => (!empty($entity->created_by) ? '<a href="' . route('users.profile', $entity->created_by) . '">' . e(\App\Facades\UserCache::name($entity->created_by)) . '</a>' : __('crud.history.unknown')),
                'date' => '<span data-toggle="tooltip" data-title="' . $entity->created_at . ' UTC' . '">' . $entity->created_at->diffForHumans() . '</span>',
            ]) !!}
            </p>
            @if (!$entity->created_at->equalTo($entity->updated_at))
            <p class="m-0">{!! __('crud.history.updated_clean', [
            'name' => (!empty($entity->updated_by) ? '<a href="' . route('users.profile', $entity->updated_by) . '">' . e(\App\Facades\UserCache::name($entity->updated_by)) . '</a>' : __('crud.history.unknown')),
            'date' => '<span data-toggle="tooltip" data-title="' . $entity->updated_at . ' UTC' . '">' . $entity->updated_at->diffForHumans() . '</span>',
        ]) !!}
            </p>
            @endif
            @can('update', $entity)
                <a href="{{ route('entities.logs', [$campaign, $entity]) }}" title="{{ __('crud.history.view') }}" class="print-none">
                    <x-icon class="fa-solid fa-history" />
                    <span class="hidden md:inline">{{ __('crud.history.view') }}</span>
                </a>
            @endcan
        @else
            <p class="m-0">
            {!! __('crud.history.created_clean', [
                'name' => (!empty($model->created_by) ? '<a href="' . route('users.profile', $model->created_by) . '">' . e(\App\Facades\UserCache::name($model->created_by)) . '</a>' : __('crud.history.unknown')),
                'date' => '<span data-toggle="tooltip" data-title="' . $model->created_at . ' UTC' . '">' . $model->created_at->diffForHumans() . '</span>',
            ]) !!}
            </p>
            <p class="m-0">{!! __('crud.history.updated_clean', [
            'name' => (!empty($model->updated_by) ? '<a href="' . route('users.profile', $model->updated_by) . '">' . e(\App\Facades\UserCache::name($model->updated_by)) . '</a>' : __('crud.history.unknown')),
            'date' =>'<span data-toggle="tooltip" data-title="' . $model->updated_at . ' UTC' . '">' . $model->updated_at->diffForHumans() . '</span>',
        ]) !!}
            </p>
        @endif
        </div>
    </div>
</div>
