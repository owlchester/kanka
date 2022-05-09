<tr>
    <td>
        <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(40) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
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
    <td>{{ $character->race }}</td>
    <td>{{ $character->sex }}</td>
    @if (Auth::user()->isAdmin())
        <td>
            @if ($character->is_private == true)
                <i class="fa-solid fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </td>
    @endif
    <td class="text-right">
        <a href="{{ route('characters.show', [$character]) }}" class="btn btn-xs btn-default">
            <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
        </a>
        @can('update', $character)
        <a href="{{ route('characters.edit', [$character]) }}" class="btn btn-xs btn-primary">
            <i class="fa-solid fa-edit" aria-hidden="true"></i> {{ trans('crud.edit') }}
        </a>
        @endcan
    </td>
</tr>
