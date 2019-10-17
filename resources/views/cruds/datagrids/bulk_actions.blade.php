@env('shadow')

@else
    @if(auth()->check())
        <div class="datagrid-bulk-actions" style="display: none">
            @can('delete', $model)
                {!! Form::button('<i class="fa fa-trash"></i> ' . trans('crud.remove'), ['type' => 'submit', 'name' => 'delete', 'class' => 'btn btn-danger', 'id' => 'crud-multi-delete']) !!}
            @endcan
            {!! Form::button('<i class="fa fa-download"></i> ' . trans('crud.export'), ['type' => 'submit', 'name' => 'export', 'class' => 'btn btn-primary', 'id' => 'crud-multi-export']) !!}
            @if (Auth::user()->isAdmin())
                {!! Form::button('<i class="fas fa-lock"></i> ' . trans('crud.actions.private'), ['type' => 'submit', 'name' => 'private', 'class' => 'btn btn-primary', 'id' => 'crud-multi-private']) !!}
                {!! Form::button('<i class="fa fa-unlock"></i> ' . trans('crud.actions.public'), ['type' => 'submit', 'name' => 'public', 'class' => 'btn btn-primary', 'id' => 'crud-multi-public']) !!}
                <a href="#" class="btn btn-default bulk-permissions" data-toggle="modal" data-target="#bulk-permissions.modal">
                    <i class="fa fa-cog"></i> {{ __('crud.tabs.permissions') }}
                </a>
            @endif
        </div>

        @include('cruds.datagrids.modals')
    @endif
@endif