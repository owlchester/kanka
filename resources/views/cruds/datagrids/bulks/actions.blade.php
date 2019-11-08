@env('shadow')

@else
    @if(auth()->check())
        <div class="datagrid-bulk-actions" style="display: none">
            {!! Form::button('<i class="fa fa-download"></i> ' . trans('crud.export'), ['type' => 'submit', 'name' => 'export', 'class' => 'btn btn-primary', 'id' => 'datagrids-bulk-actions-export']) !!}
            @if (Auth::user()->isAdmin())
                <a href="#" class="btn btn-default bulk-permissions" id="datagrids-bulk-actions-permissions" data-toggle="modal" data-target="#bulk-permissions.modal">
                    <i class="fa fa-cog"></i> {{ __('crud.tabs.permissions') }}
                </a>
                @if (isset($bulk))
                <a href="#" class="btn btn-default bulk-edit" data-toggle="modal" data-target="#bulk-edit.modal" id="datagrids-bulk-actions-batch" >
                    <i class="fa fa-edit"></i> {{ __('crud.bulk.actions.edit') }}
                </a>
                @endif
            @endif
            @can('delete', $model)
                {!! Form::button('<i class="fa fa-trash"></i> ' . trans('crud.remove'), ['type' => 'submit', 'name' => 'delete', 'class' => 'btn btn-danger', 'id' => 'datagrids-bulk-actions-delete']) !!}
            @endcan
        </div>

        {!! Form::hidden('datagrid-action', null, ['id' => 'datagrid-bulk-action']) !!}
        @include('cruds.datagrids.bulks.modals')
    @endif
@endif