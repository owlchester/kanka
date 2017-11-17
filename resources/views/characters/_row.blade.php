<tr>
    <td>
        <img class="direct-chat-img" src="{{ $character->getImageUrl(true) }}" alt="{{ $character->name }} picture">
    </td>
    <td>
        <a href="{{route('characters.show', $character->id)}}">{{ $character->name }}</a>
    </td>
    @if ($campaign->enabled('families'))
    <td>
        @if ($character->family)
            <a href="{{ route('families.show', $character->family_id) }}">{{ $character->family->name }}</a>
        @endif
    </td>
    @endif
    @if ($campaign->enabled('locations'))
    <td>
        @if ($character->location)
            <a href="{{ route('locations.show', $character->location_id) }}">{{ $character->location->name }}</a>
        @endif
    </td>
    @endif
    <td>{{ $character->age }}</td>
    <td>{{ $character->race }}</td>
    <td>{{ $character->sex }}</td>
    @if (!Auth::user()->viewer())
        <td>
            @if ($character->is_private == true)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </td>
    @endif
    <td class="text-right">
        <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-default">
            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
        </a>
        @if (Auth::user()->can('update', $character))
        <a href="{{ route('characters.edit', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
            <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.edit') }}
        </a>
        @endif
    </td>
</tr>