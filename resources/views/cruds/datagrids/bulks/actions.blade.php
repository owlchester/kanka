<?php /** @var \App\Datagrids\Datagrid $datagrid */?>
@env('shadow')

@else
    @if(auth()->check())
        <div class="datagrid-bulk-actions">
            {!! Form::button('<i class="fa fa-download"></i> ' . __('crud.export'), ['type' => 'submit', 'name' => 'datagrid-action', 'value' => 'export', 'class' => 'btn btn-primary', 'id' => 'datagrids-bulk-actions-export', 'disabled'=>'disabled']) !!}
            @if (Auth::user()->isAdmin())
                @if (!isset($datagrid) || $datagrid->bulkPermissions)
                <a href="#" class="btn btn-default bulk-permissions disabled" id="datagrids-bulk-actions-permissions" data-toggle="ajax-modal" data-target="#bulk-permissions.modal" data-url="{{ route('bulk.modal', ['view' => 'permissions']) }}">
                    <i class="fa fa-cog"></i> {{ __('crud.tabs.permissions') }}
                </a>
                @endif
                @if (isset($bulk))
                <a href="#" class="btn btn-default bulk-edit disabled" data-toggle="modal" data-target="#bulk-edit.modal" id="datagrids-bulk-actions-batch" >
                    <i class="fa fa-edit"></i> {{ __('crud.bulk.actions.edit') }}
                </a>
                @endif
                @if (!isset($datagrid) || $datagrid->bulkCopyToCampaign)
                    <a href="#" class="btn btn-default bulk-copy-campaign disabled" id="datagrids-bulk-actions-copy-campaign" data-toggle="ajax-modal" data-target="#bulk-permissions.modal" data-url="{{ route('bulk.modal', ['view' => 'copy_campaign']) }}">
                        <i class="fa fa-clone"></i> {{ __('crud.actions.copy_to_campaign') }}
                    </a>
                @endif
            @endif
            @can('delete', $model)
                <a href="#" class="btn btn-danger bulk-delete disabled" data-toggle="modal" data-target="#bulk-delete.modal" id="datagrids-bulk-actions-delete">
                    <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                </a>
            @endcan
        </div>
    @endif
@endif
