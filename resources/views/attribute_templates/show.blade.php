<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __('entities.attribute_templates')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">

        <div class="box box-solid">
            <div class="box-body">

                @can('attribute', [$model, 'add'])
                    <p class="text-right">
                        <a class="btn btn-sm btn-default" href="{{ route('entities.attributes.template', [$campaign, $model->entity]) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', [$campaign, $model->entity]) }}">
                            <i class="fa-solid fa-copy"></i> <span class="hidden-xs hidden-sm">{{ trans('entities/attributes.actions.apply_template') }}</span>
                        </a>

                        <a href="{{ route('entities.attributes.edit', [$campaign, $model->entity]) }}" class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-list"></i> <span class="hidden-xs hidden-sm">{{ trans('entities/attributes.actions.manage') }}</span>
                        </a>
                    </p>
                @endcan

                @include('entities.pages.attributes.render', ['entity' => $model->entity])
            </div>
        </div>
        @include('entities.components.posts')

        @include('cruds.partials.mentions')
        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>
