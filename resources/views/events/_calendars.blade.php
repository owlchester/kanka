<table id="calendar-list" class="table table-hover">
    <tbody><tr>
        <th class="avatar"></th>
        <th>{{ trans('calendars.fields.name') }}</th>
        <th>{{ trans('calendars.fields.type') }}</th>
        <th>{{ trans('events.fields.date') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->calendarEvents()->has('calendar')->with('calendar')->paginate() as $relation)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->calendar->getImageUrl(true) }}');" title="{{ $relation->calendar->name }}" href="{{ route('calendars.show', $relation->calendar->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('organisations.show', $relation->calendar_id) }}">{{ $relation->calendar->name }}</a>
            </td>
            <td>{{ $relation->calendar->type }}</td>
            <td>{{ $relation->date }}</td>
            <td class="text-right">
                @can('calendar', $model)
                {!! Form::open(['method' => 'DELETE', 'route' => ['calendar_event.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_calendars')->links() }}
