@extends('layouts.whiteboard', [
    'title' => __('whiteboards.create.title'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    <div id="whiteboard">
        <whiteboard
            :new="true"
            api="{{ route('whiteboards.store', $campaign) }}"
        />
    </div>

@endsection
