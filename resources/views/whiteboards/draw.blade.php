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
            :readonly="{{ !$campaign->isWyvernPremium() ? 1 : 0 }}"
        />
    </div>

@endsection
