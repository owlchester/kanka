@if(Auth::check() && !isset($exporting))
    @can('update', $model)
        <a href="{{ route($name . '.edit', ['id' => $model->id]) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
        </a>
    @endcan
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span></span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            @can('create', $model)
            <li>
                <a href="{{ route($name . '.create') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('crud.actions.new') }}
                </a>
            </li>
            <li>
                <a href="{{ route($name . '.create', ['copy' => $model->id]) }}">
                    <i class="fa fa-copy" aria-hidden="true"></i> {{ trans('crud.actions.copy') }}
                </a>
            </li>
            @endcan

            @if ((empty($disableMove) || !$disableMove) && Auth::user()->can('move', $model))
            <li>
                <a href="{{ route('entities.move', $model->entity->id) }}">
                    <i class="fa fa-exchange" aria-hidden="true"></i> {{ trans('crud.actions.move') }}
                </a>
            </li>
            @endif

            <li class="margin-bottom">
                <a href="{{ route('entities.export', $model->entity) }}">
                    <i class="fa fa-download" aria-hidden="true"></i> {{ trans('crud.actions.export') }}
                </a>
            </li>
            @can('delete', $model)
            <li>
                <button class="btn btn-danger btn-flat delete-confirm btn-block" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::open(['method' => 'DELETE','route' => [$name . '.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                {!! Form::close() !!}
            </li>
            @endcan
        </ul>
    </div>
@endif