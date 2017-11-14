<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br></th>
        <th><a href="{{ route('organisations.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('organisations.fields.name') }}</a></th>
        <th>{{ trans('organisations.fields.location') }}</th>
        <th><a href="{{ route('organisations.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('organisations.fields.type') }}</a></th>
        <th>{{ trans('organisations.fields.members') }}</th>
        @if (!Auth::user()->viewer())
            <th><a href="{{ route('organisations.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
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
                {{ $organisation->members()->has('character')->count() }}
            </td>
            @if (!Auth::user()->viewer())
                <td>
                @if ($organisation->is_private == true)
                    <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                @endif
            </td>
            @endif
            <td class="text-right">
                <a href="{{ route('organisations.show', ['id' => $organisation->id]) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
                @if (Auth::user()->can('update', $organisation))
                    <a href="{{ route('organisations.edit', ['id' => $organisation->id]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.edit') }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>