<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box">
            <div class="box-body box-profile">
                <h3 class="profile-username text-center">{{ $model->name }}
                </h3>

                @if (Auth::user()->can('update', $model))
                <a href="{{ route('attribute_templates.edit', $model->id) }}" class="btn btn-primary ">
                    <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                </a>
                @endif

                @if (Auth::user()->can('delete', $model))
                <button class="btn pull-right btn-danger delete-confirm" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::open(['method' => 'DELETE','route' => ['attribute_templates.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
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
                    <a href="#attribute" data-toggle="tooltip" title="{{ trans('attribute_templates.show.tabs.attributes') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs"> {{ trans('attribute_templates.show.tabs.attributes') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="attribute">
                    @include('cruds._attributes')
                </div>
            </div>
        </div>
        @include('cruds.boxes.history')
    </div>
</div>
