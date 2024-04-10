@extends('layouts.app', [
    'title' => trans('campaigns/webhooks.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        trans('campaigns.show.tabs.webhooks')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <div class="flex flex-col gap-5">
        @include('campaigns/webhooks.index')
    </div>
@endsection
