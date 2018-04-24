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
                        @if ($campaign->enabled('locations') && !empty($model->location))
                        <li class="list-group-item">
                            <b>{{ trans('organisations.fields.location') }}</b>
                            <span  class="pull-right">
                                <a href="{{ route('locations.show', $model->location_id) }}" data-toggle="tooltip" title="{{ $model->location->tooltip() }}">{{ $model->location->name }}</a>
                                @if ($model->location->parentLocation)
                                    , <a href="{{ route('locations.show', $model->location->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->location->parentLocation->tooltip() }}">{{ $model->location->parentLocation->name }}</a>
                                @endif
                            </span>
                            <br class="clear" />
                        </li>
                        @endif

                        @if (!empty($model->type))
                            <li class="list-group-item">
                                <b>{{ trans('organisations.fields.type') }}</b> <a class="pull-right" href="#">{{ $model->type }}</a>
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
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history">{{ trans('organisations.show.tabs.history') }}</a></li>
                    @if ($campaign->enabled('characters'))
                        <li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}"><a href="#member">{{ trans('organisations.show.tabs.members') }}</a></li>
                    @endif
                    @can('relation', $model)
                    <li class="{{ (request()->get('tab') == 'relations' ? ' active' : '') }}">
                        <a href="#relations">{{ trans('crud.tabs.relations') }}</a>
                    </li>
                    @endcan
                    @can('attribute', $model)
                        <li class="{{ (request()->get('tab') == 'notes' ? ' active' : '') }}">
                            <a href="#notes">{{ trans('crud.tabs.notes') }}</a>
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
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $model->history !!}</p>
                        </div>
                    </div>
                    @if ($campaign->enabled('characters'))
                    <div class="tab-pane {{ (request()->get('tab') == 'member' ? ' active' : '') }}" id="member">
                        @include('organisations._members')
                    </div>
                    @endif
                    @can('relation', $model)
                    <div class="tab-pane {{ (request()->get('tab') == 'relations' ? ' active' : '') }}" id="relations">
                        @include('cruds._relations')
                    </div>
                    @endcan
                    @can('attribute', $model)
                        <div class="tab-pane {{ (request()->get('tab') == 'notes' ? ' active' : '') }}" id="notes">
                            @include('cruds._notes')
                        </div>
                    @endcan
                    @can('attribute', $model)
                    <div class="tab-pane {{ (request()->get('tab') == 'attribute' ? ' active' : '') }}" id="attribute">
                        @include('cruds._attributes')
                    </div>
                    @endcan
                    @can('permission', $model)
                        <div class="tab-pane {{ (request()->get('tab') == 'permissions' ? ' active' : '') }}" id="permissions">
                            @include('cruds._permissions')
                        </div>
                    @endcan
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
