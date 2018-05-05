<p>{{ trans('crud.events.hint') }}</p>
<table id="entity-event-list" class="table table-hover">
    <tbody><tr>
        <th class="avatar"></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/calendar.name', '#events']) }}">{{ trans('calendars.fields.name') }}@if (request()->get('order') == 'events/calendar.name') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/date', '#events']) }}">{{ trans('events.fields.date') }}@if (request()->get('order') == 'events/date') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/comment', '#events']) }}">{{ trans('calendars.fields.comment') }}@if (request()->get('order') == 'events/comment') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/is_recurring', '#events']) }}">{{ trans('calendars.fields.is_recurring') }}@if (request()->get('order') == 'events/is_recurring') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->entity->events()->has('calendar')->with('calendar')->order(request()->get('order'), 'date')->paginate() as $relation)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->calendar->getImageUrl(true) }}');" title="{{ $relation->calendar->name }}" href="{{ route('calendars.show', $relation->calendar->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('calendars.show', $relation->calendar_id) }}">{{ $relation->calendar->name }}</a>
            </td>
            <td>{{ $relation->getDate() }}</td>
            <td>{{ $relation->comment }}</td>
            <td>@if ($relation->is_recurring)
                  <i class="fa fa-check"></i>
            @endif</td>
            <td class="text-right">
                @can('update', $model)
                {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_events.destroy', $relation->entity, $relation->id], 'style'=>'display:inline']) !!}
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
