<table id="notes" class="table table-hover">
    <tbody><tr>
        <th><br></th>
        <th><a href="{{ route('notes.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('notes.fields.name') }}</a></th>
        <th><a href="{{ route('notes.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('notes.fields.type') }}</a></th>
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
            <td class="text-right">
                <a href="{{ route('notes.show', ['id' => $note->id]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>