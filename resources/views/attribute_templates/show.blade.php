<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __('entities.attribute_templates')],
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">
        <x-box>
            @can('attribute', [$model, 'add'])
                <p class="text-right">
                    <a class="btn2 btn-sm btn" href="{{ route('entities.attributes.template', [$campaign, $model->entity]) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', [$campaign, $model->entity]) }}">
                        <x-icon class="copy" />
                        <span class="hidden-xs hidden-sm">{{ trans('entities/attributes.actions.apply_template') }}</span>
                    </a>

                    <a href="{{ route('entities.attributes.edit', [$campaign, 'entity' => $model->entity]) }}" class="btn2 btn-sm btn-accent">
                        <x-icon class="fa-solid fa-list" />
                        <span class="hidden-xs hidden-sm">{{ trans('entities/attributes.actions.manage') }}</span>
                    </a>
                </p>
            @endcan

            @include('entities.pages.attributes.render', ['entity' => $model->entity])
        </x-box>
        @include('entities.components.posts')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>
