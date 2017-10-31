<tr>
    <td>
        @if ($character->image)
            <img class="direct-chat-img" src="/storage/{{ $character->image }}" alt="{{ $character->name }} picture">
        @endif
    </td>
    <td>
        <a href="{{route('characters.show', $character->id)}}">{{ $character->name }}</a>
    </td>
    <td>
        @if ($character->family)
            <a href="{{ route('families.show', $character->family_id) }}">{{ $character->family->name }}</a>
        @endif
    </td>
    <td>
        @if ($character->location)
            <a href="{{ route('locations.show', $character->location_id) }}">{{ $character->location->name }}</a>
        @endif
    </td>
    <td>{{ $character->age }}</td>
    <td>{{ $character->race }}</td>
    <td>{{ $character->sex }}</td>
    <td class="text-right">
        <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
        </a>
    </td>
</tr>