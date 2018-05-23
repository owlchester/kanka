<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box">
            <div class="box-body box-profile">
                <h3 class="profile-username text-center">{{ $model->name }}
                </h3>

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
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="results">
                    <p>{{ $model->parameters }} = {{ $model->results }}</p>
                </div>
            </div>
        </div>

        <!-- actions -->
    </div>
</div>
