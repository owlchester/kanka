<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ $entityNote->name }}
        @if ($entityNote->is_private)
            <i class="fa fa-lock" title="{{ __('crud.is_private') }}"></i>
        @endif
        </h4>
    </div>
    <div class="panel-body">
        {!! $entityNote->entry !!}
    </div>
    @if (!$ajax)
        <div class="panel-footer text-right">
            @can('attribute', [$entity->child, 'edit'])
                <a href="{{ route('entities.entity_notes.edit', ['entity' => $entity, 'entity_note' => $entityNote]) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                </a>
            @endcan
        </div>
    @endif
</div>