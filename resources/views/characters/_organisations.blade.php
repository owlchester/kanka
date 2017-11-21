@if (Auth::user()->can('create', 'App\OrganisationMember'))
    <p class="text-right">
        <a href="{{ route('characters.character_organisations.create', ['character' => $model->id]) }}" class="btn btn-primary">
            {{ trans('characters.organisations.actions.add') }}
        </a>
    </p>
@endif

<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"></th>
        <th>{{ trans('organisations.fields.name') }}</th>
        <th>{{ trans('organisations.members.fields.role') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->organisations()->has('organisation')->with('organisation')->paginate() as $relation)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $relation->organisation->getImageUrl(true) }}" alt="{{ $relation->organisation->name }} picture">
            </td>
            <td>
                <a href="{{ route('organisations.show', $relation->organisation_id) }}">{{ $relation->organisation->name }}</a>
            </td>
            <td>{{ $relation->role }}</td>
            <td class="text-right">
                @if (Auth::user()->can('update', $relation))
                    <a href="{{ route('characters.character_organisations.edit', ['character' => $model, 'organisationMember' => $relation]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                    </a>
                @endif
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE','route' => ['characters.character_organisations.destroy', $model->id, $relation->id],'style'=>'display:inline']) !!}
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
