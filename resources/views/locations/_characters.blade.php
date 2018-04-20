<table id="characters" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('characters.fields.name') }}</th>
        <th>{{ trans('characters.fields.family') }}</th>
        <th>{{ trans('crud.fields.location') }}</th>
        <th>{{ trans('characters.fields.age') }}</th>
        <th>{{ trans('characters.fields.race') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->allCharacters()->acl(auth()->user())->orderBy('name', 'ASC')->with(['location', 'family'])->paginate() as $character)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(true) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('characters.show', $character->id) }}" data-toggle="tooltip" title="{{ $character->tooltip() }}">{{ $character->name }}</a>
            </td>
            <td>
                @if ($character->family)
                    <a href="{{ route('families.show', $character->family_id) }}" data-toggle="tooltip" title="{{ $character->family->tooltip() }}">{{ $character->family->name }}</a>
                @endif
            </td>
            <td>
                <a href="{{ route('locations.show', $character->location_id) }}" data-toggle="tooltip" title="{{ $character->location->tooltip() }}">{{ $character->location->name }}</a>
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

{{ $r->fragment('tab_character')->links() }}