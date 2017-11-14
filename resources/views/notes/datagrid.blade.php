<table id="notes" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br></th>
        <th><a href="{{ route('notes.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('notes.fields.name') }}</a></th>
        <th><a href="{{ route('notes.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('notes.fields.type') }}</a></th>
        @if (!Auth::user()->viewer())
            <th><a href="{{ route('notes.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $note)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $note->getImageUrl(true) }}" alt="{{ $note->name }} picture">
            </td>
            <td>
                <a href="{{ route('notes.show', $note->id) }}">{{ $note->name }}</a>
            </td>
            <td>{{ $note->type }}</td>
            @if (!Auth::user()->viewer())
                <td>
                    @if ($note->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                <a href="{{ route('notes.show', ['id' => $note->id]) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
                @if (Auth::user()->can('update', $note))
                    <a href="{{ route('notes.edit', ['id' => $note->id]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.edit') }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>