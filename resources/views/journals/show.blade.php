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
                            <b>{{ trans('journals.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                        @if ($model->date)
                        <li class="list-group-item">
                            <b>{{ trans('journals.fields.date') }}</b> <span class="pull-right">{{ $model->date }}</span>
                            <br class="clear" />
                        </li>
                        @endif
                    </ul>

                    @if (Auth::user()->can('update', $model))
                    <a href="{{ route('journals.edit', $model->id) }}" class="btn btn-primary">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>
                    @endif

                    @if (Auth::user()->can('move', $model))
                        <a href="{{ route('entities.move', $model->entity->id) }}" class="btn btn-default">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> {{ trans('crud.actions.move') }}
                        </a>
                    @endif

                    @if (Auth::user()->can('delete', $model))
                    <button class="btn btn-danger pull-right delete-confirm" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['journals.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
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
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                        <a href="#information" data-toggle="tab" aria-expanded="false">History</a>
                    </li>
                    <li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
                        <a href="#attribute" data-toggle="tab" aria-expanded="false">{{ trans('crud.tabs.attributes') }}</a>
                    </li>
                    <!--<li><a href="#journal" data-toggle="tab" aria-expanded="false">Characters</a></li>-->
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        @if (!empty($model->history))
                        <div class="post">
                            <h3>History</h3>
                            <p>{!! $model->history !!}</p>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'attribute' ? ' active' : '') }}" id="attribute">
                        @include('cruds._attributes')
                    </div></div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
