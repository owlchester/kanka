<?php /** @var \App\Datagrids\Datagrid $datagrid */?>
@env('shadow')

@else
    @if(auth()->check())
        <div class="datagrid-bulk-actions" style="display: none">
            {!! Form::button('<i class="fa fa-download"></i> ' . trans('crud.export'), ['type' => 'submit', 'name' => 'datagrid-action', 'value' => 'export', 'class' => 'btn btn-primary', 'id' => 'datagrids-bulk-actions-export']) !!}
            @if (Auth::user()->isAdmin())
                @if (!isset($datagrid) || $datagrid->bulkPermissions)
                <a href="#" class="btn btn-default bulk-permissions" id="datagrids-bulk-actions-permissions" data-toggle="modal" data-target="#bulk-permissions.modal">
                    <i class="fa fa-cog"></i> {{ __('crud.tabs.permissions') }}
                </a>
                @endif
                @if (isset($bulk))
                <a href="#" class="btn btn-default bulk-edit" data-toggle="modal" data-target="#bulk-edit.modal" id="datagrids-bulk-actions-batch" >
                    <i class="fa fa-edit"></i> {{ __('crud.bulk.actions.edit') }}
                </a>
                @endif
            @endif
            @can('delete', $model)
                {!! Form::button('<i class="fa fa-trash"></i> ' . trans('crud.remove'), ['type' => 'submit', 'name' => 'datagrid-action', 'value' => 'delete', 'class' => 'btn btn-danger', 'id' => 'datagrids-bulk-actions-delete']) !!}
            @endcan
        </div>
    @endif
@endif