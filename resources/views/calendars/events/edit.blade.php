@extends('layouts.app', [
    'title' => trans('calendars.event.edit.title', ['name' => $entity->name]),
    'description' => trans('calendars.event.edit.description'),
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => route('calendars.show', $entity->id), 'label' => $entity->name],
        trans('crud.tabs.events'),
        trans('crud.update'),
    ]
])
@section('content')
    <div class="panel panel-default">
        @include('calendars.events._edit')
    </div>
@endsection
