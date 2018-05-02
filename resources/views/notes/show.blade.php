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
                        @if (!empty($model->type))
                            <li class="list-group-item">
                                <b>{{ trans('notes.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                                <br class="clear" />
                            </li>
                        @endif
                        @if (!empty($model->is_pinned))
                            <li class="list-group-item">
                                <b>{{ trans('notes.fields.is_pinned') }}</b> <span class="pull-right"><i class="fa fa-check-circle" title="{{ trans('notes.hints.is_pinned') }}"></i></span>
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
                        <a href="#history" data-toggle="tooltip" title="{{ trans('notes.show.tabs.description') }}">
                            <i class="fa fa-align-justify"></i> <span class="hidden-sm">{{ trans('notes.show.tabs.description') }}</span>
                        </a>
                    </li>
                    @include('cruds._tabs')
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $model->description !!}</p>
                        </div>
                    </div>
                    @include('cruds._panes')
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
