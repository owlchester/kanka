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

                    @if (Auth::user()->can('update', $model))
                    <a href="{{ route('locations.edit', $model->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>
                    @endif

                    @if (Auth::user()->can('delete', $model))
                        <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                        </button>
                        {!! Form::open(['method' => 'DELETE','route' => ['locations.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                        {!! Form::close() !!}
                    @endif

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

                    <ul class="list-group list-group-unbordered">
                        @foreach ($model->locationAttributes as $attribute)
                        <li class="list-group-item">
                            <b>{{ $attribute->name }}</b> <span class="pull-right">{{ $attribute->value }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>-->
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                        <a href="#information" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.information') }}</a>
                    </li>
                    @if ($campaign->enabled('characters'))
                    <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}">
                        <a href="#character" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.characters') }}</a>
                    </li>
                    @endif
                    <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}">
                        <a href="#location" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.locations') }}</a>
                    </li>
                    <li class="{{ (request()->get('tab') == 'relations' ? ' active' : '') }}">
                        <a href="#relations" data-toggle="tab" aria-expanded="false">{{ trans('crud.tabs.relations') }}</a>
                    </li>
                    <li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
                        <a href="#attribute" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.attributes') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        <div class="post">
                            <h3>{{ trans('locations.fields.description') }}</h3>
                            <p>{!! $model->description !!}</p>
                        </div>

                        <div class="post">
                            <h3>{{ trans('locations.fields.history') }}</h3>
                            <p>{!! $model->history !!}</p>
                        </div>
                    </div>
                    @if ($campaign->enabled('characters'))
                    <div class="tab-pane {{ (request()->get('tab') == 'character' ? ' active' : '') }}" id="character">
                        @include('locations._characters')
                    </div>
                    @endif
                    <div class="tab-pane {{ (request()->get('tab') == 'location' ? ' active' : '') }}" id="location">
                        @include('locations._locations')
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'relations' ? ' active' : '') }}" id="relations">
                        @include('cruds._relations')
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'attribute' ? ' active' : '') }}" id="attribute">
                        @include('locations._attributes')
                    </div>
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
