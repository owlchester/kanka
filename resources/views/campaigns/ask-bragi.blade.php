@extends('layouts.app', [
    'title' => trans('bragi/ask-bragi.title'),
    'breadcrumbs' => [
        trans('campaigns.show.tabs.ask-bragi')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <div class="flex flex-col gap-5">
        @can('ask', $campaign)
            @livewire('bragi.ask', ['campaign' => $campaign])
        @endif
    </div>
@endsection
