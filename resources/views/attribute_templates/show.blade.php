<div class="row">
    <div class="col-md-3">
        @include('attribute_templates._menu')
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#attribute" data-toggle="tooltip" title="{{ trans('attribute_templates.show.tabs.attributes') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs"> {{ trans('attribute_templates.show.tabs.attributes') }}
                    </a>
                </li>

                @can('permission', $model)
                    <li class="pull-right" data-toggle="tooltip" title="{{ trans('crud.tabs.permissions') }}">
                        <a href="{{ route('entities.permissions', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.permissions', $model->entity) }}">
                            <i class="fa fa-cog"></i>
                        </a>
                    </li>
                @endcan
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="attribute">
                    @include('cruds._attributes')
                </div>
            </div>
        </div>
        @include('cruds.boxes.history')
    </div>
</div>
