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

                    @if ($model->title)
                        <p class="text-muted text-center">{{ $model->title }}</p>
                    @endif

                    <ul class="list-group list-group-unbordered">
                        @if ($model->family)
                            <li class="list-group-item">
                                <b>{{ trans('characters.fields.family') }}</b> <a class="pull-right" href="{{ route('families.show', $model->family_id) }}">{{ $model->family->name }}</a>
                                <br class="clear" />
                            </li>
                        @endif
                        @if ($model->location)
                            <li class="list-group-item">
                                <b>{{ trans('characters.fields.location') }}</b>
                                <span  class="pull-right">
                                    <a href="{{ route('locations.show', $model->location_id) }}">{{ $model->location->name }}</a>
                                    @if ($model->location->parentLocation)
                                        , <a href="{{ route('locations.show', $model->location->parentLocation->id) }}">{{ $model->location->parentLocation->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                        @if (!empty($model->race))
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.race') }}</b> <span class="pull-right">{{ $model->race }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                    </ul>

                    @if (Auth::user()->can('update', $model))
                    <a href="{{ route('characters.edit', ['id' => $model->id]) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>
                    @endif

                    @if (Auth::user()->can('delete', $model))
                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['characters.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.fields.physical') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <ul class="list-group list-group-unbordered">
                        @if ($model->age)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.age') }}</b> <span class="pull-right">{{ $model->age }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->sex)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.sex') }}</b> <span class="pull-right">{{ $model->sex }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->height)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.height') }}</b> <span class="pull-right">{{ $model->height }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->weight)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.weight') }}</b> <span class="pull-right">{{ $model->weight }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->eye_colour)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.eye') }}</b> <span class="pull-right">{{ $model->eye_colour }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->hair)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.hair') }}</b> <span class="pull-right">{{ $model->hair }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->skin)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.skin') }}</b> <span class="pull-right">{{ $model->skin }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->languages)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.languages') }}</b> <span class="pull-right">{{ $model->languages }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.history') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'personality' ? ' active' : '') }}"><a href="#personality" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.personality') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'free' ? ' active' : '') }}"><a href="#free" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.free') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'relation' ? ' active' : '') }}"><a href="#relation" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.relations') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'organisation' ? ' active' : '') }}"><a href="#organisation" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.organisations') }}
                        </a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $model->history !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'personality' ? ' active' : '') }}" id="personality">
                        <p><b>{{ trans('characters.fields.traits') }}</b><br />{!! nl2br(e($model->traits)) !!}</p>
                        <p><b>{{ trans('characters.fields.goals') }}</b><br />{!! nl2br(e($model->goals)) !!}</p>
                        <p><b>{{ trans('characters.fields.fears') }}</b><br />{!! nl2br(e($model->fears)) !!}</p>
                        <p><b>{{ trans('characters.fields.mannerisms') }}</b><br />{!! nl2br(e($model->mannerisms)) !!}</p>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'free' ? ' active' : '') }}" id="free">
                        <div class="post">
                            <p>{!! nl2br(e($model->free)) !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'relation' ? ' active' : '') }}" id="relation">
                        @include('characters._relations')
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'organisation' ? ' active' : '') }}" id="organisation">
                        @include('characters._organisations')
                    </div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
