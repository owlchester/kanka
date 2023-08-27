@extends('layouts.app', [
    'title' => trans('campaigns.roles.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        trans('campaigns.show.tabs.roles')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    @include('partials.errors')
    <div class="flex flex-col gap-5 max-w-7xl">
        @include('campaigns.roles.index')
    </div>
@endsection
