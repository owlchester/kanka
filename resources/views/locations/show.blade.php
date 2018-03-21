@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @if ($model->image)
                    <a href="/storage/{{ $model->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $model->image }}" alt="{{ $model->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $model->name }}
                        @if ($model->is_private)
                            <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                        @endif
                    </h3>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>{{ trans('locations.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @if (!empty($model->parentLocation))
                            <li class="list-group-item">
                                <b>{{ trans('locations.fields.location') }}</b>

                                <span class="pull-right">
                                <a href="{{ route('locations.show', $model->parentLocation->id) }}">{{ $model->parentLocation->name }}</a>
                                    @if ($model->parentLocation->parentLocation)
                                        , <a href="{{ route('locations.show', $model->parentLocation->parentLocation->id) }}">{{ $model->parentLocation->parentLocation->name }}</a>
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

            <!-- About Me Box -->
            <!--<div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">

                </div>
            </div>-->
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                        <a href="#information">{{ trans('locations.show.tabs.information') }}</a>
                    </li>
                    <li class="{{ (request()->get('tab') == 'map' ? ' active' : '') }}">
                        <a href="#map">{{ trans('locations.show.tabs.map') }}</a>
                    </li>
                    @if ($campaign->enabled('characters'))
                    <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}">
                        <a href="#character">{{ trans('locations.show.tabs.characters') }}</a>
                    </li>
                    @endif
                    <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}">
                        <a href="#location">{{ trans('locations.show.tabs.locations') }}</a>
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

                        <div class="post">
                            <h3>{{ trans('crud.fields.history') }}</h3>
                            <p>{!! $model->history !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane" id="map">
                        @include('locations._map')
                    </div>
                    @if ($campaign->enabled('characters'))
                    <div class="tab-pane" id="character">
                        @include('locations._characters')
                    </div>
                    @endif
                    <div class="tab-pane" id="location">
                        @include('locations._locations')
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
