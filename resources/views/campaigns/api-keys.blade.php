@extends('layouts.app', [
    'title' => trans('campaigns/api-keys.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        trans('campaigns.show.tabs.api-keys')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <div class="flex flex-col gap-5">
        @include('campaigns/api-keys.index')
    </div>
@endsection
