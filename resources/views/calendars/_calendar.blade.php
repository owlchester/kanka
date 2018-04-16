@inject('renderer', 'App\Renderers\CalendarRenderer')

<div class="row form-group">
    <div class="col-md-4 text-right">
        <i class="fa fa-angle-double-left"></i> {{ $renderer->previous() }}
    </div>
    <div class="col-md-4 text-center">
        <select id="calendar-year-switcher" class="form-control">
            {!! $renderer->current() !!}
        </select>
    </div>
    <div class="col-md-2 text-left">
        {{ $renderer->next() }} <i class="fa fa-angle-double-right"></i>
    </div>
</div>

<table class="calendar table table-bordered table-striped">
    <thead>
    <tr>
        @foreach ($model->weekdays() as $weekday)
            <th>{{ $weekday }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($renderer->month() as $week => $days)
        <tr>
            @foreach ($days as $day)
                <td>
                    <h5>{{ $day['day'] }}</h5>
                    @if (!empty($day['events']))
                        @foreach ($day['events'] as $event)
                            <a href="{{ route('events.show', $event) }}">{{ $event->name }}</a><br />
                        @endforeach
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>