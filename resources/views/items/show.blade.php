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
                            <b>{{ trans('items.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($campaign->enabled('locations') && !empty($model->location))
                            <li class="list-group-item">
                                <b>{{ trans('items.fields.location') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('locations.show', $model->location_id) }}">{{ $model->location->name }}</a>
                                    @if ($model->location->parentLocation)
                                        , <a href="{{ route('locations.show', $model->location->parentLocation->id) }}">{{ $model->location->parentLocation->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                            @if ($campaign->enabled('characters') && !empty($model->character))
                            <li class="list-group-item">
                                <b>{{ trans('items.fields.character') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('characters.show', $model->character->id) }}">{{ $model->character->name }}</a>
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                    </ul>

                    @if (Auth::user()->can('update', $model))
                    <a href="{{ route('items.edit', $model->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>
                    @endif

                    @if (Auth::user()->can('delete', $model))
                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['items.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#information" data-toggle="tab" aria-expanded="false">{{ trans('items.show.tabs.information') }}</a></li>
                    <!--<li><a href="#character" data-toggle="tab" aria-expanded="false">Characters</a></li>-->
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="information">
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
                    <div class="tab-pane" id="character">
                    </div>
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
