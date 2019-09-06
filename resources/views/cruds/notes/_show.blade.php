<div class="panel panel-default">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        <h4>{{ $entityNote->name }}
        @if ($entityNote->is_private)
            <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
        @endif
        </h4>
    </div>
    <div class="panel-body">
        {!! $entityNote->entry() !!}
    </div>
    @if (!$ajax)
        @can('attribute', [$entity->child, 'edit'])
        <div class="panel-footer text-right">
                <a href="{{ route('entities.entity_notes.edit', ['entity' => $entity, 'entity_note' => $entityNote]) }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i> {{ trans('crud.edit') }}
                </a>
        </div>
        @endcan
    @endif
</div>