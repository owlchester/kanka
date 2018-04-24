@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @include ('cruds._image')

                    <h3 class="profile-username text-center">{{ $model->name }}
                        @if ($model->is_private)
                            <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                        @endif
                    </h3>

                    <ul class="list-group list-group-unbordered">
                        @if (!empty($model->type))
                        <li class="list-group-item">
                            <b>{{ trans('sections.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if (!empty($model->section))
                            <li class="list-group-item">
                                <b>{{ trans('crud.fields.section') }}</b>

                                <span class="pull-right">
                                <a href="{{ route('sections.show', $model->section->id) }}" data-toggle="tooltip" title="{{ $model->section->tooltip() }}">{{ $model->section->name }}</a>
                                    @if ($model->section->section)
                                        , <a href="{{ route('sections.show', $model->section->section->id) }}" data-toggle="tooltip" title="{{ $model->section->section->tooltip() }}">{{ $model->section->section->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif

                    </ul>
                    @include('.cruds._actions')
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                        <a href="#information">{{ trans('sections.show.tabs.information') }}</a>
                    </li>
                    <li class="{{ (request()->get('tab') == 'sections' ? ' active' : '') }}">
                        <a href="#sections">{{ trans('sections.show.tabs.sections') }}</a>
                    </li>
                    <li class="{{ (request()->get('tab') == 'children' ? ' active' : '') }}">
                        <a href="#children">{{ trans('sections.show.tabs.children') }}</a>
                    </li>
                    @can('relation', $model)
                    <li class="{{ (request()->get('tab') == 'relations' ? ' active' : '') }}">
                        <a href="#relations">{{ trans('crud.tabs.relations') }}</a>
                    </li>
                    @endcan
                    @can('attribute', $model)
                    <li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
                        <a href="#attribute">{{ trans('crud.tabs.attributes') }}</a>
                    </li>
                    @endcan
                    @can('permission', $model)
                        <li class="{{ (request()->get('tab') == 'permissions' ? ' active' : '') }}">
                            <a href="#permissions">{{ trans('crud.tabs.permissions') }}</a>
                        </li>
                    @endcan
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        <div class="post">
                            <h3>{{ trans('crud.fields.description') }}</h3>
                            <p>{!! $model->description !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane" id="sections">
                        @include('sections._sections')
                    </div>
                    <div class="tab-pane" id="children">
                        @include('sections._children')
                    </div>
                    @can('relation', $model)
                    <div class="tab-pane" id="relations">
                        @include('cruds._relations')
                    </div>
                    @endcan
                    @can('attribute', $model)
                    <div class="tab-pane" id="attribute">
                        @include('cruds._attributes')
                    </div>
                    @endcan
                    @can('permission', $model)
                        <div class="tab-pane" id="permissions">
                            @include('cruds._permissions')
                        </div>
                    @endcan
                </div>
            </div>
            <!-- actions -->
        </div>
    </div>
@endsection
