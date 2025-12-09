@extends('layouts.whiteboard', [
    'title' => $whiteboard->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    <div id="whiteboard">
        <whiteboard
            save="{{ route('whiteboards.save-draw', [$campaign, $whiteboard]) }}"
            load="{{ route('whiteboards.api', [$campaign, $whiteboard]) }}"
            gallery="{{ route('gallery.browse', $campaign) }}"
            search="{{ route('search.live', $campaign) }}"
            entity="{{ route('entities.json.export', [$campaign, 0]) }}"
            user="{{ auth()->check() }}"
            :readonly="{{ auth()->check() && auth()->user()->can('update', $whiteboard->entity) && auth()->user()->can('whiteboards', $campaign) ? 0 : 1 }}"
            :creator="{{ auth()->check() && !empty($campaign) && auth()->user()->can('member', $campaign) ? 1 : 0 }}"
        />
    </div>

@endsection
