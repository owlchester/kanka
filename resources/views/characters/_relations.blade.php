<p class="text-right">
    <a href="{{ route('character_relation.create', ['character' => $character->id]) }}" class="btn btn-primary">Add new relation</a>
</p>

<table id="characters" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('characters.fields.relation') }}</th>
        <th>{{ trans('characters.fields.name') }}</th>
        <th>{{ trans('characters.fields.location') }}</th>
        <th>{{ trans('characters.fields.age') }}</th>
        <th>{{ trans('characters.fields.race') }}</th>
        <th>{{ trans('characters.fields.sex') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $character->relationships()->paginate(3) as $relation)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td><a href="{{ route('characters.show', $relation->second_id) }}">{{ $relation->second->name }}</a></td>
            <td>
                @if ($relation->second->location)
                    <a href="{{ route('locations.show', $relation->second->location_id) }}">{{ $relation->second->location->name }}</a>
                @endif
            </td>
            <td>{{ $relation->second->age }}</td>
            <td>{{ $relation->second->race }}</td>
            <td>{{ $relation->second->sex }}</td>
            <td class="text-right">
                {!! Form::open(['method' => 'DELETE','route' => ['character_relation.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'relation')->links() }}
