
@if (Auth::user()->can('update', $model))
    <a href="{{ route($name . '.edit', ['id' => $model->id]) }}" class="btn btn-primary btn-block">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
    </a>
@endif
@if (Auth::user()->can('create', $model))
    <a href="{{ route($name . '.create') }}" class="btn btn-default btn-block">
        <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('crud.actions.new') }}
    </a>
@endif

@if ((empty($disableMove) || !$disableMove) && Auth::user()->can('move', $model))
    <a href="{{ route('entities.move', $model->entity->id) }}" class="btn btn-default btn-block">
        <i class="fa fa-arrow-right" aria-hidden="true"></i> {{ trans('crud.actions.move') }}
    </a>
@endif

@if (Auth::user()->can('delete', $model))
    <button class="btn btn-danger delete-confirm btn-block" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
    </button>
    {!! Form::open(['method' => 'DELETE','route' => [$name . '.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
    {!! Form::close() !!}
@endif