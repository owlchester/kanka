<table id="characters" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('characters.fields.name') }}</th>
        <th>{{ trans('characters.fields.location') }}</th>
        <th>{{ trans('characters.fields.age') }}</th>
        <th>{{ trans('characters.fields.race') }}</th>
        <th>{{ trans('characters.fields.sex') }}</th>
    </tr>
    @foreach ($r = $family->members()->with('location')->paginate() as $relation)
        <tr>
            <td>
                @if ($relation->image)
                    <img class="direct-chat-img" src="/storage/{{ $relation->image }}" alt="{{ $relation->name }} picture">
                @endif
                <a href="{{ route('characters.show', $relation->id) }}">{{ $relation->name }}</a>
            </td>
            <td>
                @if ($relation->location)
                    <a href="{{ route('locations.show', $relation->location_id) }}">{{ $relation->location->name }}</a>
                @endif
            </td>
            <td>{{ $relation->age }}</td>
            <td>{{ $relation->race }}</td>
            <td>{{ $relation->sex }}</td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'member')->links() }}
