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
                        @if ($model->type)
                        <li class="list-group-item">
                            <b>{{ trans('quests.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
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
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#information" data-toggle="tab" aria-expanded="false">{{ trans('quests.show.tabs.information') }}</a></li>
                    @if ($campaign->enabled('characters'))
                        <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}"><a href="#character" data-toggle="tab" aria-expanded="false">{{ trans('quests.show.tabs.characters') }}</a></li>
                    @endif
                    @if ($campaign->enabled('locations'))
                        <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}"><a href="#location" data-toggle="tab" aria-expanded="false">{{ trans('quests.show.tabs.locations') }}</a></li>
                    @endif
                    @can('relation', $model)
                    <li class="{{ (request()->get('tab') == 'relations' ? ' active' : '') }}">
                        <a href="#relations" data-toggle="tab" aria-expanded="false">{{ trans('crud.tabs.relations') }}</a>
                    </li>
                    @endcan
                    @can('attribute', $model)
                    <li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
                        <a href="#attribute" data-toggle="tab" aria-expanded="false">{{ trans('crud.tabs.attributes') }}</a>
                    </li>
                    @endcan
                    @can('permission', $model)
                        <li class="{{ (request()->get('tab') == 'permissions' ? ' active' : '') }}">
                            <a href="#permissions" data-toggle="tab" aria-expanded="false">{{ trans('crud.tabs.permissions') }}</a>
                        </li>
                    @endcan
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
                    @can('relation', $model)
                    <div class="tab-pane {{ (request()->get('tab') == 'relations' ? ' active' : '') }}" id="relations">
                        @include('cruds._relations')
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
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
