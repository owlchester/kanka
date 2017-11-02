<!--<p class="text-right">
    <a href="{{ route('character_relation.create', ['character' => $character->id]) }}" class="btn btn-primary">Add new relation</a>
</p>-->

<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th></th>
        <th>{{ trans('organisations.fields.name') }}</th>
        <th>{{ trans('organisations.members.fields.role') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $character->organisations()->with('organisation')->paginate() as $relation)
        <tr>
            <td>
                @if ($relation->organisation->image)
                    <img class="direct-chat-img" src="/storage/{{ $relation->organisation->image }}" alt="{{ $relation->organisation->name }} picture">
                @endif
            </td>
            <td>
                <a href="{{ route('organisations.show', $relation->organisation_id) }}">{{ $relation->organisation->name }}</a>
            </td>
            <td>{{ $relation->role }}</td>
            <td class="text-right">
                {!! Form::open(['method' => 'DELETE','route' => ['organisation_member.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'relation')->links() }}
