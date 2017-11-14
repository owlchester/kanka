
@if (Auth::user()->can('create', \App\CharacterRelation::class))
<p class="text-right">
    <a href="{{ route('character_relation.create', ['character' => $character->id]) }}" class="btn btn-primary">
        {{ trans('characters.relations.actions.add') }}
    </a>
</p>
@endif

<table id="characters" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('characters.fields.relation') }}</th>
        <th class="avatar"><br /></th>
        <th>{{ trans('characters.fields.name') }}</th>
        <th>{{ trans('characters.fields.location') }}</th>
        <th>{{ trans('characters.fields.age') }}</th>
        <th>{{ trans('characters.fields.race') }}</th>
        <th>{{ trans('characters.fields.sex') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $character->relationships()->has('second')->with('second')->paginate() as $relation)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td>
                <img class="direct-chat-img" src="{{ $relation->second->getImageUrl(true) }}" alt="{{ $relation->second->name }} picture">
            </td>
            <td>
                <a href="{{ route('characters.show', $relation->second_id) }}">{{ $relation->second->name }}</a></td>
            <td>
                @if ($relation->second->location)
                    <a href="{{ route('locations.show', $relation->second->location_id) }}">{{ $relation->second->location->name }}</a>
                @endif
            </td>
            <td>{{ $relation->second->age }}</td>
            <td>{{ $relation->second->race }}</td>
            <td>{{ $relation->second->sex }}</td>
            <td class="text-right">
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE','route' => ['character_relation.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'relation')->links() }}
