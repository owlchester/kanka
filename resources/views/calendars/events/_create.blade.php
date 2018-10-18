<div class="panel-body">
    @include('partials.errors')

    {!! Form::open(array('route' => ['calendars.event.store', $calendar->id], 'method'=>'POST', 'data-shortcut' => "1")) !!}
    @include('calendars.events._form')

    <div class="form-group">
        <button class="btn btn-success" id="calendar-event-submit" style="display: none">{{ trans('crud.save') }}</button>
        @if (!$ajax)
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '#relation') === false ? '#relation' : null))]) !!}
        @endif
    </div>

    {!! Form::close() !!}
</div>