<?php $r = $model->entity->notes()->with('creator')->order(request()->get('order'))->paginate(); ?>
<p class="export-hidden">{{ trans('crud.notes.hint') }}</p>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('crud.tabs.notes') }}</p>

<table id="crud_notes" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'notes/name', '#notes']) }}">{{ trans('crud.notes.fields.name') }}@if (request()->get('order') == 'notes/name') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'notes/creator.name', '#notes']) }}">{{ trans('crud.notes.fields.creator') }}@if (request()->get('order') == 'notes/creator.name') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        @if (Auth::user()->isAdmin())
            <th><a href="{{ route($name . '.show', [$model, 'order' => 'notes/is_private', '#notes']) }}">{{ trans('crud.fields.is_private') }}@if (request()->get('order') == 'notes/is_private') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        @endif
        <th class="text-right">@can('attribute', [$model, 'add'])
                <a href="{{ route('entities.entity_notes.create', ['entity' => $model->entity]) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> {{ trans('crud.notes.actions.add') }}
                </a>
            @endcan
        </th>
    </tr>
    @foreach ($r as $note)
        <tr>
            <td>
                <a href="#" data-toggle="entity-note" data-target="#entity-note" data-title="{{ $note->name }}" data-entry="{{ $note->entry }}">{{ $note->name }}</a>
            </td>
            <td>
                @if ($note->creator)
                    {{ $note->creator->name }}
                @endif
            </td>
            @if (Auth::user()->isAdmin())
                <td>
                    @if ($note->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                @can('attribute', [$model, 'edit'])
                    <a href="{{ route('entities.entity_notes.edit', ['entity' => $model->entity, 'entity_note' => $note]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                    </a>
                @endcan
                @can('attribute', [$model, 'delete'])
                    {!! Form::open(['method' => 'DELETE','route' => ['entities.entity_notes.destroy', 'entity' => $model->entity, 'entity_note' => $note],'style'=>'display:inline']) !!}
                    <button class="btn btn-xs btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        <tr class="export-visible">
            <td colspan="4" style="font-size: 12pt">
                {!! $note->entry !!}
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_notes')->links() }}

<!-- Modal -->
<div class="modal fade export-hidden" id="entity-note" tabindex="false" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="entity-note-title"></h4>
            </div>
            <div class="modal-body">
                <p id="entity-note-body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.delete_modal.close') }}</button>
            </div>
        </div>
    </div>
</div>