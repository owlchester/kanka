@extends('layouts.app', [
    'title' => $event->entity->name . ' - ' . __('events.participants.title'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'participants',
        'view' => 'events._participants',
    ])
@endsection
