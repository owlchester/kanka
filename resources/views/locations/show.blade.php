<div class="row">
    <div class="col-md-3">
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
                        <b>{{ trans('locations.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if (!empty($model->parentLocation))
                        <li class="list-group-item">
                            <b>{{ trans('locations.fields.location') }}</b>

                            <span class="pull-right">
                            <a href="{{ route('locations.show', $model->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->parentLocation->tooltip() }}">{{ $model->parentLocation->name }}</a>@if ($model->parentLocation->parentLocation),
                                <a href="{{ route('locations.show', $model->parentLocation->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->parentLocation->parentLocation->tooltip() }}">{{ $model->parentLocation->parentLocation->name }}</a>
                                @endif
                            </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @include('cruds.layouts.section')
                </ul>
                @include('.cruds._actions')
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#information" data-toggle="tooltip" title="{{ trans('locations.show.tabs.information') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('locations.show.tabs.information') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->get('tab') == 'map' ? ' active' : '') }}">
                    <a href="#map" data-toggle="tooltip" title="{{ trans('locations.show.tabs.map') }}">
                        <i class="fa fa-map"></i> <span class="hidden-sm hidden-xs">{{ trans('locations.show.tabs.map') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('characters'))
                <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}">
                    <a href="#character" data-toggle="tooltip" title="{{ trans('locations.show.tabs.characters') }}">
                        <i class="fa fa-user"></i> <span class="hidden-sm hidden-xs">{{ trans('locations.show.tabs.characters') }}</span>
                    </a>
                </li>
                @endif
                <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}">
                    <a href="#location" data-toggle="tooltip" title="{{ trans('locations.show.tabs.locations') }}">
                        <i class="fa fa-globe"></i> <span class="hidden-sm hidden-xs">{{ trans('locations.show.tabs.locations') }}</span>
                    </a>
                </li>
                @include('cruds._tabs')
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
                @include('cruds._panes')
            </div>
        </div>
        <!-- actions -->
        @include('cruds.boxes.history')
    </div>
</div>
