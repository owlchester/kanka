<div class="entity-grid">

    @include('entities.components.menu_link_header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ]
    ])

    <div class="entity-submenu">
        <div class="box box-solid">
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>{{ trans('menu_links.fields.position') }}</b>
                        <span class="pull-right">{{ $model->position }}</span>
                    </li>

                    @if (!empty($model->target))
                    <li class="list-group-item">
                        <b>{{ trans('menu_links.fields.entity') }}</b>
                        <span  class="pull-right">
                            {!! $model->target->tooltipedLink() !!}
                        </span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if ($model->icon)
                        <li class="list-group-item">
                            <b>{{ trans('entities/links.fields.icon') }}</b>
                            <span  class="pull-right">
                                <i class="{{ $model->icon }}"></i>
                            </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($model->tab)
                        <li class="list-group-item">
                            <b>{{ trans('menu_links.fields.tab') }}</b>
                            <span  class="pull-right">
                                {{ $model->tab }}
                            </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($model->menu)
                        <li class="list-group-item">
                            <b>{{ trans('menu_links.fields.menu') }}</b>
                            <span  class="pull-right">
                            {{ $model->menu }}
                        </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($model->type)
                        <li class="list-group-item">
                            <b>{{ trans('menu_links.fields.type') }}</b>
                            <span  class="pull-right">
                            {{ __('entities.' . \Illuminate\Support\Str::plural($model->type)) }}
                        </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($model->filters)
                        <li class="list-group-item">
                            <b>{{ trans('menu_links.fields.filters') }}</b>
                            <span  class="pull-right">
                            {{ $model->filters }}
                        </span>
                            <br class="clear" />
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="entity-main-block">
        @include('entities.pages.logs.history')
    </div>
</div>
