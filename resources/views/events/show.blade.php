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
                        @if ($model->type)
                        <li class="list-group-item">
                            <b>{{ trans('events.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->date)
                        <li class="list-group-item">
                            <b>{{ trans('events.fields.date') }}</b> <span class="pull-right">{{ $model->date }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($campaign->enabled('locations') && !empty($model->location))
                            <li class="list-group-item">
                                <b>{{ trans('events.fields.location') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('locations.show', $model->location_id) }}" data-toggle="tooltip" title="{{ $model->location->tooltip() }}">{{ $model->location->name }}</a>
                                    @if ($model->location->parentLocation)
                                        , <a href="{{ route('locations.show', $model->location->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->location->parentLocation->tooltip() }}">{{ $model->location->parentLocation->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                        @if (!empty($model->character))
                            <li class="list-group-item">
                                <b>{{ trans('events.fields.character') }}</b> <a class="pull-right" href="{{ route('characters.show', $model->character_id) }}" data-toggle="tooltip" title="{{ $model->character->tooltip() }}">{{ $model->character->name }}</a>
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
                        <a href="#information">{{ trans('events.show.tabs.information') }}</a>
                    </li>
                    @if ($campaign->enabled('calendars'))
                        <li class="{{ (request()->get('tab') == 'calendars' ? ' active' : '') }}">
                            <a href="#calendars">{{ trans('events.tabs.calendars') }}</a>
                        </li>
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
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        @if (!empty($model->description))
                        <div class="post">
                            <h3>{{ trans('events.fields.description') }}</h3>
                            <p>{!! $model->description !!}</p>
                        </div>
                        @endif

                        @if (!empty($model->history))
                        <div class="post">
                            <h3>{{ trans('events.fields.history') }}</h3>
                            <p>{!! $model->history !!}</p>
                        </div>
                        @endif
                    </div>

                    @if ($campaign->enabled('calendars'))
                        <div class="tab-pane {{ (request()->get('tab') == 'calendars' ? ' active' : '') }}" id="calendars">
                            @include('events._calendars')
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
