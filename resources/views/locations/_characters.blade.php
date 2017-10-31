<table id="characters" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('characters.fields.name') }}</th>
        <th>{{ trans('characters.fields.family') }}</th>
        <th>{{ trans('characters.fields.age') }}</th>
        <th>{{ trans('characters.fields.race') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($location->characters()->with(['location', 'family'])->paginate() as $character)
        <tr>
            <td>
                @if ($character->image)
                    <img class="direct-chat-img" src="/storage/{{ $character->image }}" alt="{{ $character->name }} picture">
                @endif
                <a href="{{ route('characters.show', $character->id) }}">{{ $character->name }}</a>
            </td>
            <td>
                @if ($character->family)
                    <a href="{{ route('families.show', $character->family_id) }}">{{ $character->family->name }}</a>
                @endif
            </td>
            <td>{{ $character->age }}</td>
            <td>{{ $character->race }}</td>
            <td class="text-right">
                <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>