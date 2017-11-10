@if (Auth::user()->can('create', 'App\OrganisationMember'))
<p class="text-right">
    <a href="{{ route('organisation_member.create', ['organisation' => $organisation->id]) }}" class="btn btn-primary">
        {{ trans('organisations.show.actions.add_member') }}
    </a>
</p>
@endif
<table id="characters" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br></th>
        <th>{{ trans('characters.fields.name') }}</th>
        <th>{{ trans('characters.fields.location') }}</th>
        <th>{{ trans('organisations.members.fields.role') }}</th>
        <th>{{ trans('characters.fields.age') }}</th>
        <th>{{ trans('characters.fields.race') }}</th>
        <th>{{ trans('characters.fields.sex') }}</th>
        <th><br /></th>
    </tr>
    @foreach ($r = $organisation->members()->with(['character', 'character.location'])->paginate() as $relation)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $relation->character->getImageUrl(true) }}" alt="{{ $relation->character->name }} picture">
            </td>
            <td>
                <a href="{{ route('characters.show', $relation->character->id) }}">{{ $relation->character->name }}</a>
            </td>
            <td>
                @if ($relation->character->location)
                    <a href="{{ route('locations.show', $relation->character->location_id) }}">{{ $relation->character->location->name }}</a>
                @endif
            </td>
            <td>{{ $relation->role }}</td>
            <td>{{ $relation->character->age }}</td>
            <td>{{ $relation->character->race }}</td>
            <td>{{ $relation->character->sex }}</td>
            <td class="text-right">
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE','route' => ['organisation_member.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'member')->links() }}
