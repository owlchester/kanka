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
            entity="{{ route('search.json', $campaign) }}"
            :readonly="{{ auth()->check() && auth()->user()->can('update', $whiteboard->entity) && $campaign->isWyvernPremium() ? 0 : 1 }}"
        />
    </div>

@endsection
