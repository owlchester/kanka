<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th><br></th>
        <th><a href="{{ route('organisations.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('organisations.fields.name') }}</a></th>
        <th>{{ trans('organisations.fields.location') }}</th>
        <th><a href="{{ route('organisations.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('organisations.fields.type') }}</a></th>
        <th>{{ trans('organisations.fields.members') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $organisation)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $organisation->getImageUrl(true) }}" alt="{{ $organisation->name }} picture">
            </td>
            <td>
            <a href="{{ route('organisations.show', $organisation->id) }}">{{ $organisation->name }}</a>
            </td>
            <td>
                @if ($organisation->location)
                    <a href="{{ route('locations.show', $organisation->location_id) }}">{{ $organisation->location->name }}</a>
                @endif
            </td>
            <td>{{ $organisation->type }}</td>
            <td>
                {{ $organisation->members()->count() }}
            </td>
            <td class="text-right">
                <a href="{{ route('organisations.show', ['id' => $organisation->id]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>