@section('entity-header-actions-override')
    <div class="header-buttons inline-block pull-right ml-auto">
        @include('entities.headers.toggle')
        @can('update', $model)
            <a href="{{ route('timelines.reorder', $model) }}" class="btn btn-default btn-sm ">
                <x-icon class="fa-solid fa-sort"></x-icon>
                {{ __('timelines.show.tabs.reorder') }}
            </a>
            <a href="{{ route('timelines.edit', $model) }}" class="btn btn-primary btn-sm ">
                <x-icon class="pencil"></x-icon>
                {{ __('crud.edit') }}
            </a>
        @endcan
        @can('post', [$model, 'add'])
            <a href="{{ route('entities.posts.create', $model->entity) }}" class="btn btn-warning btn-sm btn-new-entity"
               data-entity-type="post" data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
                <x-icon class="plus"></x-icon>
                {{ __('crud.actions.new_post') }}
            </a>
        @endcan
    </div>
@endsection

<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('timelines'), 'label' => \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines'))],
            null
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])
        @include('timelines._timeline', ['timeline' => $model])

        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

@section('scripts')
    @parent
    @vite(['resources/js/ajax-subforms.js'])
@endsection
