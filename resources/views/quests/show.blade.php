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
                            <b>{{ trans('quests.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @include('cruds.layouts.section')
                    </ul>

                    @include('.cruds._actions', ['disableMove' => true])
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                        <a href="#information" data-toggle="tooltip" title="{{ trans('quests.show.tabs.information') }}">
                            <i class="fa fa-align-justify"></i> <span class="hidden-sm">{{ trans('quests.show.tabs.information') }}</span>
                        </a>
                    </li>
                    @if ($campaign->enabled('characters'))
                        <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}">
                            <a href="#character" data-toggle="tooltip" title="{{ trans('quests.show.tabs.characters') }}">
                                <i class="fa fa-user"></i> <span class="hidden-sm">{{ trans('quests.show.tabs.characters') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($campaign->enabled('locations'))
                        <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}">
                            <a href="#location" data-toggle="tooltip" title="{{ trans('quests.show.tabs.locations') }}">
                                <i class="fa fa-globe"></i> <span class="hidden-sm">{{ trans('quests.show.tabs.locations') }}</span>
                            </a>
                        </li>
                    @endif
                    @include('cruds._tabs')
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        <div class="post">
                            <h3>{{ trans('quests.fields.description') }}</h3>
                            <p>{!! $model->description !!}</p>
                        </div>
                    </div>
                    @if ($campaign->enabled('characters'))
                        <div class="tab-pane {{ (request()->get('tab') == 'character' ? ' active' : '') }}" id="character">
                            @include('quests._characters')
                        </div>
                    @endif
                    @if ($campaign->enabled('locations'))
                        <div class="tab-pane {{ (request()->get('tab') == 'location' ? ' active' : '') }}" id="location">
                            @include('quests._locations')
                        </div>
                    @endif
                    @include('cruds._panes')
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
