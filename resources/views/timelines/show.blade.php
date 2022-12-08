@section('entity-header-actions-override')
    <div class="header-buttons">
        <div class="btn-group">
            <div class="btn btn-default btn-sm btn-post-collapse" title="{{ __('entities/story.actions.collapse_all') }}" data-toggle="tooltip">
                <i class="fa-solid fa-grip-lines"></i>
            </div>
            <div class="btn btn-default btn-sm btn-post-expand" title="{{ __('entities/story.actions.expand_all') }}" data-toggle="tooltip">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        @can('update', $model)
            <a href="{{ route('timelines.reorder', $model) }}" class="btn btn-default btn-sm ">
                <i class="fa-solid fa-sort"></i> {{ __('timelines.show.tabs.reorder') }}
            </a>
            <a href="{{ route('timelines.edit', $model) }}" class="btn btn-primary btn-sm ">
                <i class="fa-solid fa-pencil"></i> {{ __('crud.edit') }}
            </a>
        @endcan
        @can('post', [$model, 'add'])
            <a href="{{ route('entities.posts.create', $model->entity) }}" class="btn btn-warning btn-sm btn-new-entity"
               data-entity-type="post" data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
                <i class="fa-solid fa-plus"></i> {{ __('crud.actions.new_post') }}
            </a>
        @endcan
    </div>
@endsection

<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $name)],
            null
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])
        @include('timelines._timeline', ['timeline' => $model])

        @include('cruds.partials.mentions')
        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

@section('scripts')
    @parent
    <script src="{{ mix('js/ajax-subforms.js') }}" defer></script>
@endsection
