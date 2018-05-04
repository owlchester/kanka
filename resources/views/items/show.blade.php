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
                            <b>{{ trans('items.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($campaign->enabled('locations') && !empty($model->location))
                            <li class="list-group-item">
                                <b>{{ trans('items.fields.location') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('locations.show', $model->location_id) }}" data-toggle="tooltip" title="{{ $model->location->tooltip() }}">{{ $model->location->name }}</a>
                                    @if ($model->location->parentLocation)
                                        , <a href="{{ route('locations.show', $model->location->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->location->parentLocation->tooltip() }}">{{ $model->location->parentLocation->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                        @if ($campaign->enabled('characters') && !empty($model->character))
                            <li class="list-group-item">
                                <b>{{ trans('items.fields.character') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('characters.show', $model->character->id) }}" data-toggle="tooltip" title="{{ $model->character->tooltip() }}">{{ $model->character->name }}</a>
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
                        <a href="#information" data-toggle="tooltip" title="{{ trans('items.show.tabs.information') }}">
                            <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('items.show.tabs.information') }}</span>
                        </a>
                    </li>
                    @include('cruds._tabs')
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        @if (!empty($model->history))
                        <div class="post">
                            <h3>{{ trans('items.fields.history') }}</h3>
                            <p>{!! $model->history !!}</p>
                        </div>
                        @endif
                        @if (!empty($model->description))
                        <div class="post">
                            <h3>{{ trans('items.fields.description') }}</h3>
                            <p>{!! $model->description !!}</p>
                        </div>
                        @endif
                    </div>
                    @include('cruds._panes')
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
