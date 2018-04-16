@inject('renderer', 'App\Renderers\CalendarRenderer')

<div class="row">
    <div class="col-md-4">
        {{ $renderer->previous() }}
    </div>
    <div class="col-md-4 text-center">
        <strong>{{ $renderer->current() }}</strong>
    </div>
    <div class="col-md-4 text-right">
        {{ $renderer->next() }}
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
                    <td>{{ $day }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        </tbody>
    </table>