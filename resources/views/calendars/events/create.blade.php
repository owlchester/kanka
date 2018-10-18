@extends('layouts.app', [
    'title' => trans('calendars.event.create.title', ['name' => $calendar->name]),
    'description' => trans('calendars.event.create.description'),
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => route('calendars.show', $calendar->id), 'label' => $calendar->name],
        trans('crud.tabs.events'),
    ]
])

@section('content')
    <div class="panel panel-default">
        @include('calendars.events._create')
    </div>
@endsection
