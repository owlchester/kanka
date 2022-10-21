@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.create.title', ['name' => $calendar->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => __('entities.calendars')],
        ['url' => route('calendars.show', $calendar->id), 'label' => $calendar->name],
        trans('crud.tabs.reminders'),
    ],
    'canonical' => true,
])

@section('content')
    {!! Form::open(['route' => ['calendars.event.store', $calendar->id], 'method'=>'POST', 'data-shortcut' => 1, 'class' => 'ajax-validation']) !!}

    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @include('calendars.events._form', ['colourAppendTo' => '#entity-modal'])


        </div>
        <div class="panel-footer" id="calendar-event-submit" style="display: none">

            <div class="pull-right">
                <button class="btn btn-success">
                    <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                    <span>{{ __('crud.save') }}</span>
                </button>
            </div>

            @include('partials.footer_cancel')

        </div>
    </div>

    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif

    {!! Form::close() !!}
@endsection
