<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box">
            <div class="box-body box-profile">
                <h3 class="profile-username text-center">{{ $model->name }}</h3>

                <ul class="list-group list-group-unbordered">
                    @if ($campaign->enabled('characters') && $model->character)
                        <li class="list-group-item">
                            <b>{{ trans('crud.fields.character') }}</b>
                            <span  class="pull-right">
                                <a href="{{ route('characters.show', $model->character) }}">{{ $model->character->name }}</a>
                                </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @include('cruds.layouts.section')
                </ul>

                @if (Auth::user()->can('delete', $model))
                <button class="btn pull-right btn-danger delete-confirm" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::open(['method' => 'DELETE','route' => ['dice_rolls.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
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
                <li class="active">
                    <a href="#results" data-toggle="tooltip" title="{{ trans('dice_rolls.show.tabs.results') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs"> {{ trans('dice_rolls.show.tabs.results') }}
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="results">
                    <p>{{ $model->parameters }} = {{ $model->results }}</p>
                </div>
                @include('cruds._panes')
            </div>
        </div>

        <!-- actions -->
    </div>
</div>
