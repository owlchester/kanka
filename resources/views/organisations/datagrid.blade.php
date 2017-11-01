<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th><br></th>
        <th><a href="{{ route('organisations.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('organisations.fields.name') }}</a></th>
        <th><a href="{{ route('organisations.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('organisations.fields.type') }}</a></th>
        <th>{{ trans('organisations.fields.location') }}</th>
        <th>{{ trans('organisations.fields.members') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $organisation)
        <tr>
            <td>
                @if ($organisation->image)
                    <img class="direct-chat-img" src="/storage/{{ $organisation->image }}" alt="{{ $organisation->name }} picture">
                @endif
            </td>
            <td><a href="{{ route('organisations.show', $organisation->id) }}">{{ $organisation->type }}</a></td>
            <td>
                <a href="{{ route('organisations.show', $organisation->id) }}">{{ $organisation->name }}</a>
            </td>
            <td>
                @if ($organisation->location)
                    <a href="{{ route('locations.show', $organisation->location_id) }}">{{ $organisation->location->name }}</a>
                @endif
            </td>
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
    </tbody></table>