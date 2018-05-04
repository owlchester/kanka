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
                        @if ($campaign->enabled('locations') && $model->location)
                            <li class="list-group-item">
                                <b>{{ trans('families.fields.location') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('locations.show', $model->location_id) }}">{{ $model->location->name }}</a>
                                    @if ($model->location->parentLocation)
                                        , <a href="{{ route('locations.show', $model->location->parentLocation->id) }}">{{ $model->location->parentLocation->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                        @include('cruds.layouts.section')
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
                        <a href="#history" data-toggle="tooltip" title="{{ trans('families.show.tabs.history') }}">
                            <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('families.show.tabs.history') }}</span>
                        </a>
                    </li>
                    @if ($campaign->enabled('characters'))<li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}">
                        <a href="#member" data-toggle="tooltip" title="{{ trans('families.show.tabs.member') }}">
                            <i class="fa fa-user"></i> <span class="hidden-sm hidden-xs">{{ trans('families.show.tabs.member') }}</span>
                        </a>
                    </li>
                    @endif
                    @include('cruds._tabs')
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $model->history !!}</p>
                        </div>
                    </div>
                    @if ($campaign->enabled('characters'))
                    <div class="tab-pane {{ (request()->get('tab') == 'member' ? ' active' : '') }}" id="member">
                        @include('families._members')
                    </div>
                    @endif
                    @include('cruds._panes')
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
