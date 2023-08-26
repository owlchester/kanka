@section('entity-header-actions-override')
    <div class="header-buttons flex gap-2 items-center justify-end">
        @include('entities.headers.toggle')
        @can('update', $model)
            <a href="{{ route('timelines.reorder', [$campaign, $model]) }}" class="btn2 btn-sm ">
                <x-icon class="fa-solid fa-sort"></x-icon>
                {{ __('timelines.show.tabs.reorder') }}
            </a>
            <a href="{{ route('timelines.edit', [$campaign, $model]) }}" class="btn2 btn-primary btn-sm ">
                <x-icon class="pencil"></x-icon>
                {{ __('crud.edit') }}
            </a>
        @endcan
        @can('post', [$model, 'add'])
            <a href="{{ route('entities.posts.create', [$campaign, $model->entity]) }}" class="btn2 btn-accent btn-sm btn-new-post"
               data-entity-type="post" data-toggle="tooltip" data-title="{{ __('crud.tooltips.new_post') }}">
                <x-icon class="plus"></x-icon>
                {{ __('crud.actions.new_post') }}
            </a>
        @endcan
    </div>
@endsection

<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list()
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5 px-4">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5">
            @include('entities.components.posts', ['withEntry' => true])
            @include('timelines._timeline', ['timeline' => $model])
        </div>

        @include('entities.components.pins')
    </div>
</div>
