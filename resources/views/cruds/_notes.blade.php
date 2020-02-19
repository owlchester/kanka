<?php $r = $model->entity->notes()->with(['creator', 'entity'])
        ->order(request()
        ->get('order'))
        ->paginate(); ?>
<p class="export-hidden">{{ __('entities/notes.hint') }}</p>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ __('crud.tabs.notes') }}</p>

<table id="crud_notes" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th>
            @if (auth()->check())
            <a href="{{ route($name . '.show', [$model, 'order' => 'notes/name', '#notes']) }}">{{ __('entities/notes.fields.name') }}@if (request()->get('order') == 'notes/name') <i class="fa fa-long-arrow-down"></i>@endif</a>
            @else
            {{ __('entities/notes.fields.name') }}
            @endif
        </th>
        <th class="visible-lg">
            @if (auth()->check())
            <a href="{{ route($name . '.show', [$model, 'order' => 'notes/creator.name', '#notes']) }}">{{ __('entities/notes.fields.creator') }}@if (request()->get('order') == 'notes/creator.name') <i class="fa fa-long-arrow-down"></i>@endif</a>
            @else
                {{ __('entities/notes.fields.creator') }}
            @endif
        </th>
        @if (Auth::check())
            <th>
                <a href="{{ route($name . '.show', [$model, 'order' => 'notes/visibility', '#notes']) }}">{{ __('crud.fields.visibility') }}
                    @if (request()->get('order') == 'notes/visibility') <i class="fa fa-long-arrow-down"></i>@endif
                </a>
            </th>
        @endif
        <th class="text-right">@can('entity-note', [$model, 'add'])
            <a href="{{ route('entities.entity_notes.create', ['entity' => $model->entity]) }}" class="btn btn-primary btn-sm"
                ><i class="fa fa-plus"></i> <span class="visible-lg-inline">{{ __('entities/notes.actions.add') }}</span>
            </a>
        @endcan
        </th>
    </tr>
    @foreach ($r as $note)
        <tr>
            <td>
                <a href="{{ route('entities.entity_notes.show', [$note->entity, $note]) }}" data-toggle="ajax-modal"
                   data-target="#large-modal" data-url="{{ route('entities.entity_notes.show', [$note->entity, $note]) }}"
                   data-title="{{ $note->name }}" data-entry="{{ $note->entry() }}">{{ $note->name }}</a>
            </td>
            <td class="visible-lg">
                @if ($note->creator)
                    {{ $note->creator->name }}
                @endif
            </td>
            @if (Auth::check())
                <td>
                    @include('cruds.partials.visibility', ['model' => $note])
                </td>
            @endif
            <td class="text-right">
                @can('entity-note', [$model, 'edit'])
                    <a href="{{ route('entities.entity_notes.edit', ['entity' => $model->entity, 'entity_note' => $note]) }}" class="btn btn-xs btn-primary" title="{{ __('crud.edit') }}">
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan
                @can('entity-note', [$model, 'delete'])
                    <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $note->name }}"
                            data-target="#delete-confirm" data-delete-target="delete-form-{{ $note->id }}"
                            title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                        {!! Form::open(['method' => 'DELETE','route' => ['entities.entity_notes.destroy', 'entity' => $model->entity, 'entity_note' => $note], 'style '=> 'display:inline', 'id' => 'delete-form-' . $note->id]) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        <tr class="export-visible">
            <td colspan="4" style="font-size: 12pt">
                {!! $note->entry() !!}
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_notes')->links() }}
